<template>
	<view class="body">
		<view class="pay">
			<view class="pay-view">
				<image class="pay-img" src="../../../../static/wx.png" mode="widthFix" />
				<view class="pay-text">微信支付</view>
			</view>
			<view class="ckeck">
				<checkbox checked="true" color="#ED6E11"><text class="moren">默认</text></checkbox>
			</view>
		</view>

		<!-- 提交栏 -->
		<view class="pos">
			<navigator url="../zhifu/zhifu" open-type="navigate"><view class="pos-text">去支付549.00</view></navigator>
		</view>
	</view>
</template>

<script>
export default {
	data() {
		return {};
	},
	methods: {}
};
</script>

<style>
.body {
	overflow: hidden;
	margin-top: 1%;
}
.ckeck {
	margin-left: 20%;
	font-size: 28rpx;
	margin-top: 3%;
}

.pay {
	width: 100%;
	background-color: #fff;
	height: 100rpx;
	display: flex;
}
.pay-view {
	width: 60%;
	display: flex;
}

.pay-img {
	width: 50rpx;
	height: 50rpx;
	margin-top: 20rpx;
	margin-left: 20rpx;
}

.pay-text {
	margin-top: 25rpx;
	margin-left: 10rpx;
}

#ckeck {
	margin-left: 400rpx;
	margin-top: 20rpx;
}

/* 提交栏 */
.pos {
	width: 100%;
	height: 6%;
	position: fixed;
	bottom: 0;
	background-color: #ff8c00;
}

.pos-text {
	text-align: center;
	margin-top: 20rpx;
	color: #fff;
}
</style>
