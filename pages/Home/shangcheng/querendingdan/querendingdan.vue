<template>
	<view v-if="pagesShow">
		<view class="xian"></view>
		<view class="addressBar">
			
			<navigator url="../dizhi/dizhi?pages=place_order" v-if="address == ''">
				<view class="addressBar-name">选择收货地址</view>
				<image class="addressBar-image" src="/static/jiantou.png"></image>
				<view class="d-flex">
					<view class="site"></view>
				</view>
				<view class="caution"><text class="">为减少接触，您可以在收货详细地址后增加如小区北门、保安亭、等方便提货的地址</text></view>
			</navigator>
			
			<navigator url="../dizhi/dizhi?pages=place_order" v-else>
				<view class="addressBar-name">{{address.name}} {{address.tel}}</view>
				<image class="addressBar-image" src="/static/jiantou.png"></image>
				<view class="d-flex">
					<view class="label">地址</view>
					<view class="site">{{address.province}}{{address.city}}{{address.area}}{{address.detail}}</view>
				</view>
				<view class="caution"><text class="">为减少接触，您可以在收货详细地址后增加如小区北门、保安亭、等方便提货的地址</text></view>
			</navigator>
			
		</view>
		<view class="hr"></view>
		<radio-group >
		<view>
			<view class="xian"></view>
			<view class="pay">
				<view class="pay-view">
					<image class="pay-img" src="../../../../static/wx.png" mode="widthFix" />
					<view class="pay-text">微信支付</view>
				</view>
				<view class="ckeck">
					<radio class="radio" value="2" :checked="pay_type==='2'" @click="radio('2')" /></radio>
				</view>
			</view>
			<view class="xian"></view>
			<view class="pay">
				<view class="pay-view">
					<image class="pay-img" src="../../../../static/zfb.jpg" mode="widthFix" />
					<view class="pay-text">支付宝支付</view>
				</view>
				<view class="ckeck">
					<radio class="radio" color="#ED6E11" value="1" :checked="pay_type==='1'" @click="radio('1')" /></radio>
				</view>
			</view>
		</view>
		</radio-group>
		<view class="pos">
			<view class="post">实付款：</view>
			<view class="pos-text">¥{{moneyTotal / 100}}</view>
			<view class="pos-view1">
				<view @click="addOrderCreate"><view class="pos-Text">提交订单</view></view>
			</view>
		</view>
	</view>
</template>

<script>
import uniNumberBox from '@/components/uni-ui/uni-number-box/uni-number-box.vue';

import net from '../../../../common/net.js';
export default {
	components: {
		uniNumberBox
	},
	data() {
		return {
			// 商品信息
			productInfo: {},
			// 数量
			num: 1,
			// 总金额
			moneyTotal: '',
			address: [],
			// 全局显示
			pagesShow: false,
			// 支付方式
			radio(e){
				// console.log(e)
				this.pay_type=e;
			}
		};
	},
	
	onLoad(options) {
		if (options.num) {
			this.num = options.num;
		}
		// 获取产品信息
		this.getProductInfo(options.product);
		// 获取默认收货地址
		this.getDeAddress();
	},

	methods: {
		// 获取产品信息
		getProductInfo(index) {
	    	net({
	        	url:"/V1/getproductinfo",
	            method:'get',
				data:{ product: index},
	            success: (res) => {
					this.productInfo = res.data.success.data;
					this.moneyTotal = this.productInfo.price * this.num;
					// console.log(this.productInfo);
	            }
	      	})
		},
		
		// 获取默认收货地址
		getDeAddress(){
			net({
	        	url: "/V1/getDefaultAddress",
	            method: 'get',
	            success: (res) => {
					this.pagesShow = true;
					if (res.data.success) {
						this.address = res.data.success.data;
					}
	            }
	      	})
		},
		
		// 生成订单
		addOrderCreate(){
			
			if (!this.pay_type) {
				uni.showToast({
					title: '请选择支付方式',
					icon: 'none'
				});
				return false;
			}
			
			if (this.address == '') {
				uni.showToast({ title: '请选择收货地址', icon: 'none' });
				return false;
			}
			
			// 显示加载动画
			uni.showLoading({
				duration: 10000,
				mask: true,
			})
			
			net({
	        	url:"/V1/addOrderCreate",
	            method: 'POST',
				data:{
					'product_id' : this.productInfo.id,
					'product_price' : this.productInfo.price,
					'numbers' : this.num,
					'price' : this.moneyTotal,
					'address' : this.address.id,
					'pay_type' : this.pay_type
				},
	            success: (res) => {
					// 关闭加载动画
					uni.hideLoading();
					
					if (res.data.success) {
						if(this.pay_type == '1'){
							uni.requestPayment({
							    provider: 'alipay',
							    orderInfo: res.data.success.data.sign, //微信、支付宝订单数据
							    success: function (res) {
							        console.log('success:' + JSON.stringify(res));
							    },
							    fail: function (err) {
							        console.log('fail:' + JSON.stringify(err));
							    }
							});
						}else{
							uni.requestPayment({
							    provider: 'wxpay',
							    orderInfo: res.data.success.data.sign, //微信、支付宝订单数据
							    success: function (res) {
							        console.log('success:' + JSON.stringify(res));
							    },
							    fail: function (err) {
							        console.log('fail:' + JSON.stringify(err));
							    }
							});
						}
						
					} else {
						uni.showToast({
							title: res.data.error.message,
							icon: 'none'
						})
					}
	            }
	      	})
		}
	}
};
</script>

<style>
	@import url("../../style/place_order.css");
</style>
