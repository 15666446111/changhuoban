<template>
	<view>
		<!-- 选择SN号 -->
		<view class="start-over">
			<view class="select">
				<text class="select-name">机具起始SN:</text>
				<text class="select-name">201907050097599</text>
				<image class="select-img" src="/static/jiantou.png" mode="widthFix" style="width:60rpx; height: 60rpx;"></image>
			</view>
			<view class="select-xian"></view>
			<view class="select">
				<text class="select-name">机具结束SN:</text>
				<text class="select-name">201907050097508</text>
				<image class="select-img" src="/static/jiantou.png" mode="widthFix"></image>
			</view>
			<view class="select-xian"></view>
			<view class="hint">提示:区间划拨可能存在序列号间断，或已激活</view>
			<view class="select-button">继 续 添 加</view>
		</view>
		<!-- sn号显示 -->
		<view class="show">
			<view class="show-title">
				<text class="title-name">起始SN</text>
				<text class="title-name">结束SN</text>
				<text class="title-text">数量</text>
			</view>
			<view class="select-xian"></view>
			
			<view v-for="(item, index) in show" :key="index">
				<view class="show-sn">
					<view class="sn-name">{{ item.name }}</view>
					<view class="sn-name">{{ item.text }}</view>
					<view class="amount">
						<view class="sn-amount">{{ item.amount }}</view>
						<image class="sn-img" :src="item.src" mode="widthFix"></image>
					</view>
				</view>
				<view class="select-xian"></view>
			</view>
		</view>
		<view style="height: 100upx"></view>
		<view class="button">确 认 选 择<text> (数 量)</text></view>
	</view>
</template>

<script>

export default {

	data() {
		return {
			show: [
				{ name: '201907050097599', text: '201907050097599', amount: '2', src: '/static/chahao.png' },
				{ name: '201907050097599', text: '201907050097599', amount: '29', src: '/static/chahao.png' },
				{ name: '201907050097599', text: '201907050097599', amount: '2', src: '/static/chahao.png' },
				{ name: '201907050097599', text: '201907050097599', amount: '33', src: '/static/chahao.png' },
				{ name: '201907050097599', text: '201907050097599', amount: '33', src: '/static/chahao.png' }
			]
		};
	},
	methods: {}
};
</script>

<style> 
.button{
	position: fixed;
	width: 100%;
	background-color: #ff8c00;
	bottom: 0px;
	height: 90upx;
	text-align: center;
	line-height: 90upx;
	color: #fff;
	font-size: 35upx;
}
/* SN选择 */
.start-over {
	background-color: #ffffff;
	width: 92%;
	margin-left: 4%;
	margin-top: 20upx;
	overflow: hidden;
	box-shadow: #efe9e9 3px 3px 8px 3px;
	border-radius: 7px 7px 7px 7px;
	height: 430upx;
}
.select {
	width: 100%;
	height: 100upx;
	line-height: 100upx;
	position: relative;
}
.select-name {
	font-size: 33upx;
	margin-left: 30upx;
	color: #333;
}
.select-img {
	width: 60rpx;
	height: 60rpx;
	position: absolute;
	top: 20upx;
	right: 10upx;
}
.select-xian {
	width: 100%;
	height: 1upx;
	background-color: #f1f1f1;
}
.hint {
	color: #999;
	text-align: center;
	height: 90upx;
	line-height: 80upx;
}
.select-button{
	background-color: #ff8c00;
	color: #fff;
	width: 60%;
	margin-left:20%;
	height: 70upx;
	text-align: center;
	line-height: 70upx;
	font-size: 35upx;
}
/* SN显示 */
.show {
	background-color: #ffffff;
	width: 92%;
	margin-left: 4%;
	margin-top: 20upx;
	overflow: hidden;
	box-shadow: #efe9e9 3px 3px 8px 3px;
	border-radius: 7px 7px 7px 7px;
	height: 100%;
}
.show-title {
	display: flex;
	width: 100%;
	height: 70upx;
	line-height: 70upx;
}
.title-name {
	width: 40%;
	text-align: center;
	font-size: 30upx;
}
.title-text {
	width: 20%;
	text-align: center;
	font-size: 30upx;
}
.amount {
	width: 20%;
	display: flex;
	position: relative;
	text-align: center;
	height: 80upx;
	line-height: 80upx;
}
.sn-amount {
	width: 70%;
	height: 80upx;
	line-height: 80upx;
}
.sn-img {
	width: 40upx;
	height: 40upx;
	position: absolute;
	right: 20upx;
	top: 18upx;
}
.show-sn {
	width: 100%;
	display: flex;
	height: 80upx;
	line-height: 80upx;
}
.sn-name {
	width: 40%;
	text-align: center;
	height: 80upx;
	line-height: 80upx;
}
</style>
