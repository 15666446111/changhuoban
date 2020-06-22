<template>
	<section class="Tabs-Page">
		<s-tabs :effect="true" v-model="activeTab" @change="change" :nav-per-view="5">
			<s-tab title="<span>全部订单</span>">
				<view class="shoppingMall" v-for="(item, index) in orderList" :key="index">
					<!-- <view class="order"><text>商城订单</text></view> -->
					<view class="mall">
						<view class="order-number">
							<view class="number">订单号:{{ item.order_no }}</view>
							<view class="pay">{{status == 0 ? '未支付' : '已支付'}}</view>
						</view>
						<view class="mall-xian1"></view>
						<view class="information">
							<image class="information-img" :src="item.image" mode="widthFix" />
							<view class="information-view">
								<view class="information-text">{{item.title}}</view>
								<view class="information-figure">¥{{item.good_price / 100}} × {{item.numbers}}</view>
							</view>
						</view>
						<view class="mall-xian"></view>
						<view class="total1">
							<view class="total-text">合计：¥{{item.order_price / 100}}</view>
							<!-- <view class="total-text1">删除订单</view> -->
						</view>
					</view>
				</view>
			</s-tab>
			<s-tab title="商城订单">
				<view class="shoppingMall" v-for="(item, index) in orderList" :key="index">
					<!-- <view class="order"><text>商城订单</text></view> -->
					<view class="mall">
						<view class="order-number">
							<view class="number">订单号:{{ item.order_no }}</view>
							<view class="pay">{{status == 0 ? '未支付' : '已支付'}}</view>
						</view>
						<view class="mall-xian1"></view>
						<view class="information">
							<image class="information-img" :src="item.image" mode="widthFix" />
							<view class="information-view">
								<view class="information-text">{{item.title}}</view>
								<view class="information-figure">¥{{item.good_price / 100}} × {{item.numbers}}</view>
							</view>
						</view>
						<view class="mall-xian"></view>
						<view class="total1">
							<view class="total-text">合计：¥{{item.order_price / 100}}</view>
							<!-- <view class="total-text1">删除订单</view> -->
						</view>
					</view>
				</view>
			</s-tab>
			<!-- <s-tab title="申卡订单">
				<view class="shoppingMall">
					<view class="mall">
						<view class="people">
							<view class="people-name">畅伙伴</view>
							<view class="people-phone">13588888888</view>
						</view>
						<view class="AoolyFor">
							<view class="banks">
								<view class="banks-bank">浦发银行</view>
								<view class="banks-text">浦发银行标准卡</view>
							</view>
							<view class="messages">
								<view class="message">
									<view class="message-name">申请时间：</view>
									<view class="message-time">2019-11-29 19:21:15</view>
								</view>
							</view>
							<view class="messages">
								<view class="message">
									<view class="message-name">申请状态：</view>
									<view class="message-time">待查询</view>
								</view>
							</view>
							<view class="messages">
								<view class="message">
									<view class="message-name">返现金额：</view>
									<view class="message-time">120.00</view>
								</view>
							</view>
						</view>
						<view class="inquire-mark" style="position: relative;">
							<view class="message-mark">订单号SC2019122109551972539097</view>
							<view class="message-inquire">
								<navigator url="" open-type="navigate"><view class="inquire-text">进度查询</view></navigator>
							</view>
						</view>
					</view>
				</view>
			</s-tab>
			<s-tab title="积分订单">
				<view class="shoppingMall">
					<view class="mall">
						<view class="order-number"><view class="number">订单号SC2019122109551972539097</view></view>
						<view class="mall-xian1"></view>
						<view class="AoolyFor">
							<view class="applyFor">
								<view class="bank">工商银行</view>
								<view class="appluFor-time">2019-11-29 19:21:15</view>
							</view>
							<view class="integrals">
								<view class="integral">
									<view class="integral-name">1000000</view>
									<view class="integral-text">使用积分</view>
								</view>
								<view class="integral">
									<view class="integral-name">1040.00</view>
									<view class="integral-text">兑换金额</view>
								</view>
								<view class="status"><view class="status-text">审核成功</view></view>
							</view>
						</view>
						<view class="mall-xian"></view>
						<view class="turn"><view class="turn-text">兑换成功</view></view>
					</view>
				</view>
			</s-tab> -->
		</s-tabs>
	</section>
</template>

<script>
import sTabs from '@/s-ui/s-tabs';
import sTab from '@/s-ui/s-tab';

import net from '../../../common/net.js';

export default {
	components: {
		sTabs,
		sTab
	},
	
	data() {
		return {
			ClassIndex: 3,
			classIndex: 3,
			tabIndex: 0,
			srcollinto: '',
			scrollH: 500,
			activeTab: 0,
			// orde: [{ name: '待查询' }, { name: '已完成' }, { name: '已失败' }, { name: '无效订单' }],
			// shangcheng: [
			// 	{
			// 		number: '订单号:SC2019122109551972539097',
			// 		pay: '待付款',
			// 		img: 'https://ccx.changhuoban.com/public/upload/xcx/sct.png',
			// 		text: 'MP70普通版（3台）',
			// 		figure: '¥594.00 × 1',
			// 		total: '合计：¥594.00',
			// 		delete: '删除订单'
			// 	},
			// 	{
			// 		number: '订单号SC2019122109551972539097',
			// 		pay: '已付款',
			// 		img: 'https://ccx.changhuoban.com/public/upload/xcx/sct.png',
			// 		text: 'MP70普通版（3台）',
			// 		figure: '¥594.00 × 1',
			// 		total: '合计：¥594.00',
			// 		delete: '删除订单'
			// 	}
			// ]
			
			orderList: {}
		};
	},
	
	onLoad() {
		// 获取订单列表
		this.getOrderList('all');
		uni.showLoading();
	},
	
	methods: {
		change(index) {
			
			if(index == 0){
				this.getOrderList('all');
			}
			
			if(index == 1){
				this.getOrderList('shop');
			}
		},
		
		// 获取订单列表
		getOrderList(type){
			net({
	        	url:"/V1/getOrderUser",
	            method:'get',
				data:{type: type},
	            success: (res) => {
					uni.hideLoading();
					this.orderList = res.data.success.data;
	            } 
	      	})
		}
	}
};
</script>

<style>
@import url(../style/orders.css);
</style>
