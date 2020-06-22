<template>
	<view>
		<view class="parcel">
			<view class="common"><text class="common-text">常 见 问 题</text></view>

			<view class="xian"></view>
			<view class="">
				<view class="issue">
					<text class="issue-text">畅伙伴功能介绍</text>
					<image class="issue-img" src="../../../static/jiantou.png" mode="widthFix" />
				</view>
				<view class="xian"></view>
				<view class="issue">
					<text class="issue-text">钱客通功能介绍</text>
					<image class="issue-img" src="../../../static/jiantou.png" mode="widthFix" />
				</view>
				<view class="xian"></view>
				<view class="issue">
					<text class="issue-text">钱包功能介绍</text>
					<image class="issue-img" src="../../../static/jiantou.png" mode="widthFix" />
				</view>
				<view class="xian"></view>
				<view class="issue">
					<text class="issue-text">磁条卡认证方式</text>
					<image class="issue-img" src="../../../static/jiantou.png" mode="widthFix" />
				</view>
			</view>
		</view>
		<view class="">
			<view class="pos">
				<view class="for">
					<view class="pos-view">
						<image class="pos-img" src="../../../static/xiugai.png" mode="widthFix" />
						<view class="pos-text">装机问题</view>
					</view>
					<view class="pos-view">
						<image class="pos-img" src="../../../static/xiugai.png" mode="widthFix" />
						<view class="pos-text">到账问题</view>
					</view>
					<view class="pos-view">
						<image class="pos-img" src="../../../static/xiugai.png" mode="widthFix" />
						<view class="pos-text">使用问题</view>
					</view>
					<view class="pso-xian"></view>
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
.parcel {
	overflow: hidden;
	width: 100%;
}

.issue {
	width: 100%;
	display: flex;
	position: relative;
	height: 80rpx;
	background-color: #fff;
}

.common {
	margin-top: 10rpx;
	height: 50rpx;
}

.common-text {
	margin-left: 4%;
	font-size: 30rpx;
	font-weight: 600;
}

.issue-img {
	width: 6%;
	position: absolute;
	right: 4%;
	top: 20rpx;
}

.issue-text {
	width: 80%;
	margin-left: 4%;
	font-size: 28rpx;
	margin-top: 3%;
}

.xian {
	width: 100%;
	height: 1px;
	background-color: #dbdada;
}

/*  */
.pos {
	width: 100%;
	background-color: #fff;
	height: 100rpx;
	position: fixed;
	bottom: 0;
	display: flex;
}
.for {
	width: 100%;
	display: flex;
}

.pos-view {
	width: 100%;
	display: flex;
}

.pos-img {
	width: 20%;
	margin-top: 25rpx;
	margin-left: 30rpx;
}

.pos-text {
	width: 60%;
	font-size: 28rpx;
	margin-top: 30rpx;
	margin-left: 10rpx;
}

.pso-xian {
	width: 1px;
	height: 80rpx;
	background-color: #c5c3c3;
	margin-top: 10rpx;
}
</style>
