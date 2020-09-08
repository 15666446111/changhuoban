<template>
	<view>
		<view class="titlebars">
			<!-- 头部内容栏 -->
			<view class="titlebar">
				<view class="rise">
					<view class="rise-head">
						<image class="head" src="/static/huoban/tb.png" />
						<view class="name">{{ merchantInfo.merchant_name }}</view>
						<view class="id">
							<view class="ID">商户号:{{ merchantInfo.merchant_code}}</view>
						</view>
					</view>
				</view>
			</view>
			<view class="hengxian"></view>
		</view>
		<view class="backgroundColor">
			<view class="data">
				<view class="phone">手机号</view>
				<view class="mark">{{ merchantInfo.merchant_phone }}</view>
			</view>
			<view class="dara-xian"></view>
			<view class="data">
				<view class="phone">绑定时间</view>
				<view class="mark">{{ merchantInfo.time}}</view>
			</view>
			<view class="dara-xian"></view>
			<view class="data">
				<view class="phone">激活状态</view>
				<view class="mark">{{ merchantInfo.active_status == '1' ? '已激活' : '未激活' }}</view>
			</view>
			<view class="dara-xian"></view>
			
			<!--
			<navigator  hover-class="none"  :url="'../activeFirst/activeFirst?terminal=' + merchantInfo.merchant_sn">
			<view class="data">
				<view class="phone">活动详情</view>
				<view class="mark">查看</view>
			</view>
			</navigator>
			-->
			
			<view class="dara-xian"></view>
			<navigator :url="'../trade/trade?merchant=' + merchantInfo.id">
				<view class="data">
					<view class="phone">交易明细</view>
					<view class="mark">查看</view>
				</view>
			</navigator>
			
			<view class="dara-xian"></view>
			<navigator :url="'../rate_details/rate_details?code=' + merchantInfo.merchant_code" v-if="type == 2">
				<view class="data">
					<view class="phone">商户费率</view>
					<view class="mark">查看</view>
				</view>
			</navigator>
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
			type: '',
			mid: '',
			merchantInfo: [],
		};
	},
	
	onLoad(options) {
		this.type 	= uni.getStorageSync('type');

		this.mid = options.id ? options.id : '1';
		// 获取商户详细信息
		this.loadModal.show = true;
		this.getMerchangInfo(this.mid);
	},
	
	methods: {
		// 获取商户列表
		getMerchangInfo(mid){
			net({
				url: '/V1/getMerchantInfo',
				method: 'GET',
				data:{ id: mid },
				success: (res) => {
					this.loadModal.show = false;
					if(res.data.success){
						this.merchantInfo = res.data.success.data;
					}else{
						uni.showToast({
							title:red.data.error.message,
							icon: 'none',
							position: 'bottom'
						})
					}
				}
			})
		}
		
	}
};
</script>

<style>
	@import url("../../style/merchant_details.css");
</style>