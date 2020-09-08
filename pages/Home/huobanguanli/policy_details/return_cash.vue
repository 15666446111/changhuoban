<template>
	<view>
		<view class="fr_top">
			<image class="fr_iamge" src="../../../../static/mark.png"></image>
			<view class="view_p">注：当保存参数后新参数即时生效。</view>
		</view>
		
		<!-- 返现设置 -->
		<view class="body" v-if="activePrice != '' || activePrice != undefined">
			<view class="view_h1"><view class="text">激活参数（元）</view></view>
			<view class="rule"></view>
			<view class="rule-view">
				<view class="rule_p">
					<view class="view_p2 view_p4">激活返现</view>
					<input class="rule_input" type="number" v-model="activePrice.active_money" /> 元
					<view class="view_s">{{activePrice.active_money_min}} ~ {{activePrice.active_money_max}} 元</view>
				</view>
			</view>
			<view class="rule"></view>
			
			<button class="button" @click="setActive()">确 认 修 改</button>
		</view>
		
		<view class="body" v-if="standardPrice.length > 0">
			<view class="view_h1"><view class="text">达标参数（元）</view></view>
			<view class="rule"></view>
			<block v-for="(item, index) in standardPrice" :key="index">
				<view class="rule-view">
					<view class="rule_p">
						<view class="view_p2 view_p4 view_standard">{{item.standard_start}} ~ {{item.standard_end}} 天
							交易 <text class="trade-text">{{item.standard_trade}} </text>元，返
						</view>
						<input class="rule_input" type="number" v-model="item.standard_price" /> 元
						<view class="view_s">{{item.min}} ~ {{item.max}} 元</view>
					</view>
				</view>
				<view class="rule"></view>
			</block>
			
			<button class="button" @click="setStandard()">确 认 修 改</button>
		</view>
		
		<view class="cu-load load-modal" v-if="loadModal.show">
		   <image src="/static/public/loading.png" mode="aspectFit"></image>
		   <view class="gray-text">{{ loadModal.text }}</view>
		</view>
	</view>
</template>

<script>
import net from '../../../../common/net.js';
export default {
	data() {
		return {
			loadModal: {
				show: false,
				text: '加载中...'
			},
			pid: '',			// 政策id
			uid: '',			// 用户id
			
			// 激活参数
			activePrice: [],
			// 达标参数
			standardPrice: [],
			
			setStandardData: []
		};
	},
	
	onLoad(options) {
		this.pid = options.pid;
		this.uid = options.uid;
		
		this.loadModal.show = true;
		// 获取用户结算价信息
		this.getActive();
		this.getStandard();
	},
	
	methods: {
		
		// 获取用户政策信息
		getActive(){
			net({
				url:"/V1/getUserActive",
				method:'GET',
				data:{
					uid: this.uid,
					pid: this.pid
				},
				success: (res) => {
					// console.log(res);
					this.loadModal.show = false;
					if (res.data.success) {
						if (res.data.success.data) {
							this.activePrice.active_money = res.data.success.data.active.active_money / 100;
							this.activePrice.active_money_max = res.data.success.data.active.active_money_max / 100;
							this.activePrice.active_money_min = res.data.success.data.active.active_money_min / 100;
						}
					} else {
						uni.showToast({
							title: res.data.error.message,
							icon: 'none'
						})
					}
				}
	      	})
		},
		
		// 获取用户达标信息
		getStandard(){
			net({
				url:"/V1/getUserStandard",
				method:'GET',
				data:{
					uid: this.uid,
					pid: this.pid
				},
				success: (res) => {
					console.log(res);
					if (res.data.success) {
						this.standardPrice = res.data.success.data;
						this.standardPrice.forEach((item, index) => {
							item.max = item.max / 100;
							item.min = item.min / 100;
							item.standard_price = item.standard_price / 100;
							item.standard_trade = item.standard_trade / 100;
						})
					} else {
						uni.showToast({
							title: '达标返现获取失败：' + res.data.error.message,
							icon: 'none'
						})
					}
				}
	      	})
		},
		
		// 激活返现设置方法
		setActive(){
			// 激活返现金额验证
			if (this.activePrice.active_money > this.activePrice.active_money_max
			 || this.activePrice.active_money < this.activePrice.active_money_min) {
				uni.showToast({
					title: '激活返现金额设置不在合理区间内',
					icon: 'none',
					mask: true
				});
				return false;
			}
			
			// 加载动画
			this.loadModal.show = true;
			
			net({
				url:"/V1/setUserActive",
				method: 'POST',
				data:{
					uid: this.uid,
					pid: this.pid,
					return_money: this.activePrice.active_money * 100
				},
				success: (res) => {
					this.loadModal.show = false;
					
					let that = this;
					if (res.data.success) {
						uni.showToast({
							title: '激活返现设置成功',
							icon: 'none',
							position: 'bottom'
						});
						setTimeout(function() {
							uni.redirectTo({
								url: './return_cash?uid=' + that.uid + '&pid=' + that.pid
							})
						}, 1500)
					} else {
						uni.showToast({
							title: '激活返现设置失败：' + res.data.error.message,
							icon: 'none',
							position: 'bottom'
						})
					}
	            },
			})
		},
		
		// 设置达标返现
		setStandard(){
			// 达标返现金额验证
			var error = false;
			this.standardPrice.forEach((item, index) => {
				if (item.standard_price > item.max || item.standard_price < item.min) {
					uni.showToast({
						title: item.standard_start + '~' + item.standard_end + '天达标返现金额不在合理区间内',
						icon: 'none',
						position: 'bottom'
					})
					error = true;
				}
				
				this.setStandardData.push({'index': item.index, 'standard_price' : Number(item.standard_price * 100)});
			})
			if (error) {
				return false;
			}
			
			// 加载动画
			this.loadModal.show = true;
			
			net({
				url:"/V1/setUserStandard",
				method: 'POST',
				data:{
					uid: this.uid,
					pid: this.pid,
					standard: this.setStandardData
				},
				success: (res) => {
					this.loadModal.show = false;
					let that = this;
					if (res.data.success) {
						uni.showToast({
							title: '达标返现设置成功',
							icon: 'none',
							position: 'bottom'
						});
						setTimeout(function() {
							uni.redirectTo({
								url: './return_cash?uid=' + that.uid + '&pid=' + that.pid
							})
						}, 1500)
					} else {
						uni.showToast({
							title: '达标返现设置失败：' + res.data.error.message,
							icon: 'none',
							position: 'bottom'
						})
					}
	            },
			})
		}
	}
};
</script>

<style>
@import url("../../style/profit_data.css");
.body {
	padding-bottom: 30rpx;
	/* margin-bottom: 40rpx; */
}
.button {
	margin-top: 30rpx;
}
</style>
