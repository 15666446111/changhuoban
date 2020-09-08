<template>
	<view>
		<view class="profit">
			<!-- <view class="fr_top">
				<image class="fr_iamge" src="../../../../static/mark.png"></image>
				<view class="view_p">注：当保存参数后新参数即时生效。</view>
			</view> -->
			
			<!-- 结算价调整 -->
			<view class="body" v-if="tradePrice.length > 0">
				<view class="view_h1">
					<view class="text">结算价参数</view>
				</view>
				<view class="rule"></view>
				<!-- 信用卡 -->
				<block v-for="(item, index) in tradePrice" :key="index">
					<view class="rule-view">
						<view class="rule_p" v-if="item.title != '借记卡封顶'">
							<view class="view_p2">{{item.title}}</view>
							<input class="rule_input" type="number" v-model="item.price" />%
							<view class="view_s">{{item.min}}% ~ {{item.max}}%</view>
						</view>
						<view class="rule_p" v-else>
							<view class="view_p2">{{item.title}}</view>
							<input class="rule_input" type="number" v-model="item.price" />元
							<view class="view_s">{{item.min}}元 ~ {{item.max}}元</view>
						</view>
					</view>
					<view class="rule"></view>
				</block>
			</view>
			<view class="tips">注：当保存参数后新参数即时生效。</view>
			<button class="button" @click="submitForm()">确 认 修 改</button>
		</view>
		
		<view class="policy">
			<view class="view_h1"><view class="text type-title">活动列表</view></view>
			<navigator  hover-class="none"  class="data-list" :url="'./return_cash?pid=' + item.id + '&uid=' + uid" v-for="(item, index) in policyList" :key="index">
				<view class="data" style="border-top: 1px solid #eee;">
					<view class="phone">{{item.title}}</view>
					<view class="mark">查看</view>
				</view>
			</navigator>
			<view v-if="policyList == undefined" style="padding-top: 50rpx; color:#999; text-align: center;">
				—— 暂无活动信息 ——
			</view>
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
			gid: '',			// 政策id
			uid: '',			// 用户id
			
			// 结算价参数
			tradePrice: [],
			policyList: [],
			
			setPrice: []
		};
	},
	
	onLoad(options) {
		this.gid = options.gid;
		this.uid = options.uid;
		
		this.loadModal.show = true;
		// 获取用户结算价信息
		this.getUserPrice();
		this.getPolicy();
	},
	
	methods: {
		// 获取用户结算价信息
		getUserPrice(){
			net({
				url:"/V1/userPrice",
				method:'GET',
				data:{
					uid: this.uid,
					gid: this.gid
				},
				success: (res) => {
					// console.log(res);
					this.loadModal.show = false;
					if (res.data.success) {
						// 结算信息
						if (res.data.success.data.list) {
							var tradeList = res.data.success.data.list;
							for (var i = 0; i < tradeList.length; i++) {
								if (tradeList[i].title == '借记卡封顶') {
									tradeList[i].price /= 100;
									tradeList[i].min /= 100;
									tradeList[i].max /= 100;
								} else {
									tradeList[i].price /= 1000;
									tradeList[i].min /= 1000;
									tradeList[i].max /= 1000;
								}
							}
							this.tradePrice = tradeList;
						}
						
					} else {
						uni.showToast({
							title: res.data.error.message,
							icon: 'none'
						})
					}
					
				},
				fail: () => {
					uni.showToast({
						title: '政策信息获取失败',
						icon: 'none'
					})
				},
	      	})
		},
		
		// 获取用户政策信息
		getPolicy(){
			net({
				url:"/V1/userPolicy",
				method:'GET',
				data:{
					uid: this.uid,
					gid: this.gid
				},
				success: (res) => {
					console.log(res);
					if (res.data.success) {
						this.policyList = res.data.success.data;
					} else {
						uni.showToast({
							title: res.data.error.message,
							icon: 'none'
						})
					}
				}
	      	})
		},
		
		// 提交表单
		submitForm(){
			var error = 0;
			this.tradePrice.forEach((item, key) => {
				if (item.price > item.max) {
					uni.showToast({
						title: item.title + '结算可设置最大值为' + item.max,
						icon: 'none',
						mask: true
					})
					error = 1;
				}
				
				if (item.price < item.min) {
					uni.showToast({
						title: item.title + '结算可设置最小值为'+ item.min,
						icon: 'none',
						mask: true
					})
					error = 1;
				}
				
				const price = item.title == '借记卡封顶' ? item.price * 100 : item.price * 1000;
				this.setPrice.push({'index': item.index, 'price' : Number(price)});
			});
			
			if (error == 1) {
				return false;
			}
			
			this.loadModal.show = true;
			net({
				url:"/V1/setUserPrice",
				method: 'POST',
				data:{
					uid: this.uid,
					gid: this.gid,
					set_price: this.setPrice
				},
	            success: (res) => {
					console.log(res);
					this.loadModal.show = false;
					if (res.data.success) {
						uni.showToast({
							title: '设置成功',
							icon: 'none',
							position: 'bottom'
						});
						
						var that = this;
						setTimeout(function() {
							uni.redirectTo({
								url: './share_profit?gid=' + that.gid + '&uid=' + that.uid
							})
						}, 1500);
					} else {
						uni.showToast({
							title: res.data.error.message,
							icon: 'none'
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
</style>
