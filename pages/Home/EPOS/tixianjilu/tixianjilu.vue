<template>
	<view>
		<view class="" style="width: 60%; height: 70upx; line-height: 70upx; margin-left: 20upx;">
			共提现金额：
			<text>10000.00</text>
		</view>
		<block v-for="(item, index) in banck" :key="index">
			<view style="background-color: #fff; position: relative;">
				<view class="label">{{ item.leabe }}</view>
				<view class="d-flex">
					<view class="gy-back">
						<view class="gy-back-text">{{ item.text }}</view>
						<view class="gy-back-name">{{ item.name }}</view>
					</view>
				</view>
				<view class="gy-back1">
					<view class="gy-back-text1">{{ item.text1 }}</view>
					<view class="gy-back-name1">{{ item.name1 }}</view>
				</view>
				<view class="xuxian"></view>
				<text style="margin-left: 80%; font-size: 28upx; color: #444;">{{ item.jishi }}</text>
			</view>
			<view class="geduan" style="height:20upx;"></view>
		</block>
	</view>
</template>

<script>
export default {
	data() {
		return {
			banck: [
				{
					leabe: '成功',
					text: '到账平安银行(尾号3333)',
					name: '提现金额：100.00元',
					text1: '2020/03/18 14:26:51',
					jishi: '提现成功'
				},
				{
					leabe: '失败',
					text: '到账平安银行(尾号3333)',
					name: '提现金额：100.00元',
					text1: '2020/03/18 14:26:51',
					jishi: '提现失败'
				}
			]
		};
	},
	methods: {}
};
</script>

<style>
.gy-back {
	margin-left: 15%;
	display: flex;
	width: 85%;
	height: 50upx;
	margin-top: 25upx;
	position: relative;
}
.gy-back1 {
	margin-left: 15%;
	display: flex;
	width: 85%;
	height: 50upx;
	position: relative;
}
.gy-back-text {
	font-size: 28upx;
}
.gy-back-name {
	font-size: 28upx;
	position: absolute;
	color: #ff0000;
	right: 40upx;
}
.gy-back-text1 {
	font-size: 20upx;
	color: #666666;
}
.gy-back-name1 {
	font-size: 20upx;
	color: #666666;
	position: absolute;
	right: 40upx;
}
.label {
	background-color: #5b9ac5;
	color: #fff;
	width: 80upx;
	text-align: center;
	height: 80upx;
	line-height: 80upx;
	border-radius: 40px;
	position: absolute;
	top: 27upx;
	left: 20upx;
}

.xuxian {
	border-bottom: 1px dashed #f1f1f1;
}
</style>
