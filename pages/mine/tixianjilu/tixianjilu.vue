<template>
	<view class="background">
		<view class="top">
			<view class="view1">
				<view class="fview">
					<image src="/static/minsheng.png" class="img"></image>
					<view class="ms">民生银行/8888</view>
					<view class="je">6500.00</view>
				</view>
				<view class="fview">
					<view class="sj">2019/12/06 15:06</view>
					<view class="zt">申请中</view>
				</view>
			</view>
			
			<view class="line"></view>
			
			<view class="view1">
				<view class="fview">
					<image src="/static/minsheng.png" class="img"></image>
					<view class="ms">民生银行/8888</view>
					<view class="je">6500.00</view>
				</view>
				<view class="fview">
					<view class="sj">2019/12/06 15:06</view>
					<view class="zt">打款成功</view>
				</view>
			</view>
			<view class="line"></view>

			<view class="view1">
				<view class="fview">
					<image src="/static/minsheng.png" class="img"></image>
					<view class="ms">民生银行/8888</view>
					<view class="je">6500.00</view>
				</view>
				<view class="fview">
					<view class="sj">2019/12/06 15:06</view>
					<view class="zt">驳回：核对卡号</view>
				</view>
			</view>
			
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
.background {
	width: 100%;
	height: 100%;
}
.top {
	width: 94%;
	background-color: #fff;
	border-radius: 10px;
	margin-left: 3%;
	margin-top: 2%;
}
.view1 {
	width: 100%;
	height: 160rpx;
	position: relative;
}
.img {
	width: 100rpx;
	height: 100rpx;
	margin-top: 5%;
	margin-left: 8%;
}
.fview {
	display: flex;
}
.ms {
	font-size: 30upx;
	margin-top: 6%;
	margin-left: 30rpx;
	height: 50rpx;
}
.je {
	position: absolute;
	right: 5%;
	font-size: 30rpx;
	color: #ffb31f;
	top: 27%;
}
.sj {
	color: #666;
	font-size: 28rpx;
	margin-left: 26.5%;
	margin-top: -6%;
}
.zt {
	color: #666;
	font-size: 28rpx;
	position: absolute;
	right: 4%;
	top: 55%;
}
.line {
	width: 94%;
	margin-left: 3%;
	height: 1rpx;
	background-color: #c5c3c3;
}
</style>
