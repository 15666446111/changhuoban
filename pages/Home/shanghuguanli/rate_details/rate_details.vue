<template>
	<view>
		<view class="profit">
			<view class="fr_top">
				<image class="fr_iamge" src="../../../../static/mark.png"></image>
				<view class="view_p">注：当保存参数后新参数即时生效。</view>
			</view>
			
			<view class="body" v-if="rateList.length > 0">
				<view class="view_h1">
					<view class="text">商户费率参数</view>
				</view>
				<view class="rule"></view>
				<!-- 信用卡 -->
				<block v-for="(item, index) in rateList" :key="index">
					<view class="rule-view">
						<view class="rule_p" v-if="item.is_top == 0">
							<view class="view_p2">{{item.title}}</view>
							<input class="rule_input" type="number" v-model="item.default_rate" />%
							<view class="view_s">{{item.min_rate}}% ~ {{item.max_rate}}%</view>
						</view>
						<view class="rule_p" v-else>
							<view class="view_p2">{{item.title}}</view>
							<input class="rule_input" type="number" v-model="item.default_rate" />元
							<view class="view_s">{{item.min_rate}}元 ~ {{item.max_rate}}元</view>
						</view>
					</view>
					<view class="rule"></view>
				</block>
			</view>
			<button class="button" @click="submitForm()">确 认 修 改</button>
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
			merchant_code: '',
			
			rateList: [],
			setRate: []
		};
	},
	
	onLoad(options) {
		this.merchant_code = options.code;
		
		this.loadModal.show = true;
		this.getMerchantsRate()
	},
	
	methods: {
		// 获取用户结算价信息
		getMerchantsRate(){
			net({
				url:"/V1/getMerchantsRate",
				method:'GET',
				data:{
					code: this.merchant_code
				},
				success: (res) => {
					console.log(res);
					this.loadModal.show = false;
					if (res.data.success) {
						this.rateList = res.data.success.data;
						this.rateList.forEach((item, index) => {
							item.default_rate = item.default_rate / 1000;
							item.max_rate = item.is_top == 0 ? item.max_rate / 1000 : item.max_rate / 100000;
							item.min_rate = item.is_top == 0 ? item.min_rate / 1000 : item.min_rate / 100000;
							
						})
					} else {
						uni.showToast({
							title: res.data.error.message,
							icon: 'none',
							position: 'bottom'
						})
					}
				},
				fail: () => {
					uni.showToast({
						title: '商户费率信息获取失败',
						icon: 'none',
						position: 'bottom'
					})
				},
	      	})
		},
		
		// 提交表单
		submitForm(){
			var error = 0;
			this.rateList.forEach((item, key) => {
				if (item.default_rate > item.max_rate) {
					uni.showToast({
						title: item.title + '费率可设置最大值为' + item.max_rate,
						icon: 'none',
						mask: true
					})
					error = 1;
				}
				
				if (item.default_rate < item.min_rate) {
					uni.showToast({
						title: item.title + '费率可设置最小值为'+ item.min_rate,
						icon: 'none',
						mask: true
					})
					error = 1;
				}
				
				const price = item.is_top == 1 ? item.default_rate * 100000 : item.default_rate * 1000;
				this.setRate.push({'index': item.index, 'default_rate' : Number(price)});
			});
			
			if (error == 1) {
				return false;
			}
			
			console.log(this.setRate);
			this.loadModal.show = true;
			net({
				url:"/V1/setMerchantsRate",
				method: 'POST',
				data:{
					code: this.merchant_code,
					rate: this.setRate
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
								url: './rate_details?code=' + that.merchant_code
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
.button {
	margin-top: 60rpx;
}
</style>
