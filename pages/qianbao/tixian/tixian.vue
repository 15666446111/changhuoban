<template>
	<view class="background">
		<navigator  hover-class="none"  url="tijiaoyinhangka/tijiaoyinhangka">
			<view class="top">
				<image src="/static/minsheng.png" class="img"></image>
				<view class="fview">
					<view style="font-size: 30upx;">民生银行</view>
					<view style="font-size: 30upx;">622622******8888</view>
				</view>
				<image src="/static/jiantou.png" class="cxk"></image>
			</view>
		</navigator>
		<view class="body">
			<view class="select-view tab">
				<view class="select-text" @tap="toggleTab('selector')">{{ resultInfo.result }}</view>
				<w-picker mode="selector" defaultVal="分润钱包" @confirm="onConfirm" ref="selector" themeColor="#f00" :selectList="selectList"></w-picker>
				<image class="select-image" src="/static/EPOS/jiantou.png" />
			</view>
			<view class="bview">
				<text>可提现金额：</text>
				<text style="color: #EE9900;">6500.00</text>
				<text>元</text>
			</view>
			<view class="hengxian"></view>
			<view class="bview d-flex">
				<input class="qbtxje" placeholder="请输入提现金额" placeholder-class="place" />
				<view style="color:#f0ad4e; font-size: 30upx; height: 100upx; line-height: 100upx;">全部提现</view>
			</view>
			<view class="hengxian"></view>
			<view class="bview">
				<text>应到金额：</text>
				<text style="color:#f0ad4e;">5980.00</text>
				<text style="margin-left:10upx;">元</text>
			</view>
			<view class="hengxian"></view>
			<view class="bview4">
				<view>提示：手续费0元，税点8%，单笔提现金额不低于200元</view>
				<view>提现时间：9：00~21:00,请注意查收短信或查询提现进度</view>
			</view>
		</view>

		<button class="button">立即提现</button>
	</view>
</template>

<script>
import wPicker from '@/components/w-picker/w-picker.vue';
let _this = null;
export default {
	components: {
		wPicker
	},
	data() {
		return {
			title: 'Hello',
			startYear: new Date().getFullYear(),
			selectList: [
				{
					label: '分润钱包',
					value: 1
				},
				{
					label: '返现钱包',
					value: 2
				},
				{
					label: '其他钱包',
					value: 3
				}
			],
			resultInfo: {
				result: '请选择提现钱包'
			}
		};
	},
	computed: {},
	mounted() {},
	methods: {
		toggleTab(str) {
			this.$refs[str].show();
		},
		onConfirm(val) {
			console.log(val);
			this.resultInfo = { ...val };
		}
	}
};
</script>

<style>
.bview4 view {
	font-size: 25upx;
	color: #666;
	margin-left: 30upx;
	height: 60upx;
	line-height: 60upx;
}
.body {
	background-color: #fff;
	width: 92%;
	margin-left: 4%;
	border-radius: 20upx;
	margin-top: 20upx;
	height: 550upx;
}
.qbtxje {
	width: 75%;
	height: 100upx;
	line-height: 100upx;
}
.bview {
	width: 90%;
	height: 100upx;
	line-height: 100upx;
	font-size: 30upx;
	margin-left: 30upx;
}
.background {
	min-height: 100%;
	overflow: hidden;
	height: 1000rpx;
}
.top {
	width: 92%;
	height: 155rpx;
	border-radius: 8rpx;
	background-color: white;
	margin: 0 auto;
	margin-top: 20rpx;
	position: relative;
	overflow:hidden ;
}
.img {
	width: 80rpx;
	height: 80rpx;
	position: absolute;
	top: 36rpx;
	left: 30rpx;
}
.fview {
	margin-left: 150upx;
	margin-top: 25upx;
}
.cxk {
	width: 55rpx;
	height: 55rpx;
	position: absolute;
	right: 30rpx;
	top: 50rpx;
}
.button {
	margin-top: 30rpx;
	width: 70%;
	font-size: 28rpx;
	color: white;
	background-color: rgb(252, 132, 19);
}
.select-image {
	width: 40upx;
	height: 40upx;
	margin-top: 10upx;
	position: absolute;
	right: 40upx;
	top: 20upx;
}
.select-view {
	display: flex;
	height: 100upx;
	position: relative;
}
.hengxian {
	width: 100%;
	height: 1upx;
	background-color: #f1f1f1;
}
.select-text {
	height: 100upx;
	width: 100%;
	line-height: 100upx;
	margin-left: 30upx;
	font-size: 28upx;
}
</style>
