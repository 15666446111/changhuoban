<template>
	<view>
		<view class="class">
			<view class="class-view">
				<view class="class-text">机具总数(台):</view>
				<view class="class-figure">500</view>
				<view class="chakan">查 看 ></view>
			</view>
			<view class="hengxian"></view>
			<view class="class-view2">
				<view class="view-text">
					<view class="text">未绑定</view>
					<view class="figure">45</view>
				</view>
				<view class="shuxian"></view>
				<view class="view-text">
					<view class="text">已绑定</view>
					<view class="figure">15</view>
				</view>
				<view class="shuxian"></view>
				<view class="view-text">
					<view class="text">已激活</view>
					<view class="figure">440</view>
				</view>
				<view class="shuxian"></view>
				<view class="view-text">
					<view class="text">已达标</view>
					<view class="figure">245</view>
				</view>
			</view>
		</view>
		<view class="class">
			<view class="class-view">
				<view class="class-text">我的机具(台):</view>
				<view class="class-figure">300</view>
				<view class="chakan">查 看 ></view>
			</view>
			<view class="hengxian"></view>
			<view class="class-view2">
				<view class="view-text">
					<view class="text">未绑定</view>
					<view class="figure">45</view>
				</view>
				<view class="shuxian"></view>
				<view class="view-text">
					<view class="text">已绑定</view>
					<view class="figure">15</view>
				</view>
				<view class="shuxian"></view>
				<view class="view-text">
					<view class="text">已激活</view>
					<view class="figure">440</view>
				</view>
				<view class="shuxian"></view>
				<view class="view-text">
					<view class="text">已达标</view>
					<view class="figure">245</view>
				</view>
			</view>
		</view>
		<view class="class-view3">
			<view class="view-text">
				<image src="../../../static/jjhb.png" class="image"></image>
				<view class="figure">机具划拨</view>
			</view>
			<view class="shuxian"></view>
			<view class="view-text">
				<image src="../../../static/jjhuib.png" class="image"></image>
				<view class="figure">机具回拨</view>
			</view>
			<view class="shuxian"></view>
			<view class="view-text">
				<image src="../../../static/hbjl.png" class="image"></image>
				<view class="figure">调拨记录</view>
			</view>
			<view class="shuxian"></view>
			<view class="view-text">
				<image src="../../../static/zddj.png" class="image"></image>
				<view class="figure">终端定价</view>
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
.class-view3 {
	width: 90%;
	display: flex;
	height: 190rpx;
	background-color: #fff;
	border-radius: 20rpx;
	margin-left: 5%;
	margin-top: 20%;
}
.image {
	width: 70rpx;
	height: 80rpx;
	margin-top: 4%;
}
.text {
	font-size: 28rpx;
	color: #666666;
}
.figure {
	font-size: 28rpx;
	margin-top: 2%;
}
.shuxian {
	width: 2rpx;
	height: 90rpx;
	background-color: #c8c7cc;
	margin-top: 20rpx;
}
.class-view2 {
	width: 100%;
	display: flex;
	height: 140rpx;
}
.view-text {
	width: 25%;
	text-align: center;
	margin-top: 3%;
}
.hengxian {
	width: 92%;
	height: 1rpx;
	background-color: #c8c7cc;
	margin-left: 4%;
}
.chakan {
	font-size: 30rpx;
	color: #f19952;
	width: 20%;
	margin-left: 40%;
	margin-top: 3%;
}
.class-text {
	font-size: 28rpx;
	color: #666;
	width: 25%;
	margin-top: 3%;
}
.class-figure {
	font-size: 33rpx;
	font-weight: 600;
	color: #f19952;
	margin-left: 2%;
	margin-top: 3%;
}
.class-view {
	display: flex;
	margin-left: 4%;
	margin-top: 4%;
	width: 100%;
	height: 100rpx;
}
.class {
	width: 90%;
	height: 100%;
	background-color: #fff;
	margin-left: 5%;
	border-radius: 20rpx;
	margin-top: 2%;
	overflow: hidden;
}
</style>
