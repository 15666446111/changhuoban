<template>
	<view>
		<!-- 选择框 -->
		<view class="select">
			<view class="select-view">
				<view class="select-div">
					<view class="select-text">类 型</view>
					<image class="image" src="../../../../static/huoban/xjx.png"></image>
				</view>
				<view class="shuxian"></view>
				<view class="select-div">
					<view class="select-text">类 型</view>
					<image class="image" src="../../../../static/huoban/xjx.png"></image>
				</view>
			</view>
			<view class="hengxian"></view>
			<view class="select-div1">
				<view class="div-text">全部</view>
				<view class="shuxian1"></view>
				<view class="div-text">划拨记录</view>
				<view class="shuxian1"></view>
				<view class="div-text">上级回拨</view>
				<view class="shuxian1"></view>
				<view class="div-text">我的回拨</view>
			</view>
			<view class="hengxian"></view>
			<button>确 定</button>
		</view>
		<!--  -->
		<view class="content">
			<view class="content-view">
				<view v-for="(item, index) in merchantList" :key='index'>
					<view class="content-div">
						<view class="div">
							<view class="content-text">调拨用户:{{item.friend_name}}</view>
							<view class="content-text1">类型:{{item.state == 1 ? '划拨' : '回拨'}}</view>
						</view>
						<view class="div">
							<view class="name">SN: {{item.merchant_sn }}</view>
							<view class="time">{{item.created_at}}</view>
						</view>
					</view>
					<view class="hengxian1"></view>
				</view>
			</view>
		</view>
	</view>
</template>

<script>
import net from '../../../../common/net.js';
export default {
	data() {
		return {
			merchantList: {}
		};
	},
	
	onLoad() {
		// 获取划拨回拨记录
		this.getTransferLog();
	},
	
	methods: {
		// 获取划拨回拨记录
		getTransferLog(){
			net({
				url: '/V1/getTransferLog',
				method: 'GET',
				success: (res) => {
					if (res.data.success) {
						this.merchantList = res.data.success.data;
					} else {
						uni.showToast({
							title: res.data.error.message,
							icon: 'none'
						})
					}
					// console.log(res);
				}
			})
		}
	}
};
</script>

<style>
@import url("../../style/transfer_log.css");
</style>
