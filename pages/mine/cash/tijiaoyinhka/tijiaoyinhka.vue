<template>
	<view>
		<!-- 第一栏 -->
		<view class="add">
			<view class="add-for">
				<view class="add-view">
					<view class="add-name">姓名：</view>
					<view class="add-text">畅伙伴</view>
				</view>
							<view class="add-xian"></view>
				<view class="add-view">
					<view class="add-name">身份证号:</view>
					<view class="add-text">370784201912245579</view>
				</view>
				<view class="add-xian"></view>
			</view>
			<view class="add-for">
				<view class="add-view">
					<view class="add-name">银行卡号：</view>
					<input placeholder="请输入银行卡号" class="add-text1" placeholder-class="place" />
					<image class="add-img" src="../../../../static/zxj.png" mode="widthFix" />
				</view>
			</view>
		</view>
		<!-- 第二栏 -->
		<view class="bank-card">
			<view class="bankCard-for">
				<navigator url="../xuanzeyinhang/xuanzeyinhang" open-type="navigate">
					<view class="bank">
						<view class="bank-name">开户行：</view>
						<view class="bank-text">请选择开户行</view>
						<image class="bank-img" src="../../../../static/jiantou.png" mode="widthFix" />
					</view>
				</navigator>
				<view class="add-xian"></view>
				<view class="bank">
					<view class="bank-name">开户地区：</view>
					<view class="bank-text">请选择地区</view>
					<image class="bank-img" src="../../../../static/jiantou.png" mode="widthFix" />
				</view>
				<view class="add-xian"></view>
				<view class="bank">
					<view class="bank-name">开户支行：</view>
					<view class="bank-text">请选择开户支行</view>
					<image class="bank-img" src="../../../../static/jiantou.png" mode="widthFix" />
				</view>
				<view class="add-xian"></view>
			</view>
			<view class="bankCard-for">
				<view class="bank">
					<view class="bank-name">预留手机号：</view>
					<input placeholder="请输入银行预留手机号" class="bank-text" placeholder-class="place" />
					<image class="bank-img" src="/images/jiantou.png" mode="widthFix" />
				</view>
				<view class="add-xian"></view>
			</view>
			<view class="bankCard-for">
				<view class="bank">
					<view class="bank-name">验证码：</view>
					<input placeholder="请输入验证码" class="bank-text1" placeholder-class="place" />
					<view class="bank-yz"><view class="bank-Text">获取验证码</view></view>
				</view>
			</view>
		</view>
		<button>保 存</button>
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
.add {
	width: 90%;
	margin-left: 5%;
	background-color: #fff;
	border-radius: 15rpx 15rpx 15rpx 15rpx;
	margin-top: 10rpx;
	box-shadow: #d9d9d9 0 0 4px 0;
}

.add-view {
	width: 100%;
	display: flex;
	height: 100rpx;
}

.add-name {
	width: 23%;
	margin-top: 30rpx;
	font-size: 28rpx;
	margin-left: 8%;
}

.add-text {
	width: 70%;
	margin-top: 30rpx;
	font-size: 30rpx;
	font-weight: 600;
	color: #f98021;
}

.add-text1 {
	width: 40%;
	margin-top: 30rpx;
	font-size: 30rpx;
}

.add-xian {
	width: 94%;
	height: 1px;
	background-color: #c5c3c3;
	margin-left: 3%;
}

.add-img {
	width: 10%;
	margin-top: 15rpx;
	margin-left: 10rpx;
}

/*  */
.bank-card {
	width: 90%;
	margin-left: 5%;
	background-color: #fff;
	box-shadow: #d9d9d9 0 0 4px 0;
	margin-top: 20rpx;
	border-radius: 15rpx 15rpx 15rpx 15rpx;
}

.bank {
	display: flex;
	width: 100%;
	position: relative;
	height: 100rpx;
}

.bank-name {
	width: 25%;
	margin-top: 30rpx;
	font-size: 28rpx;
	margin-left: 8%;
}

.bank-text {
	width: 45%;
	margin-top: 30rpx;
	font-size: 28rpx;
	color: #777;
}

.bank-text1 {
	width: 35%;
	margin-top: 30rpx;
	font-size: 28rpx;
}

.bank-img {
	width: 7%;
	position: absolute;
	right: 5%;
	top: 25rpx;
}

.bank-yz {
	width: 170rpx;
	font-size: 28rpx;
	background-color: #f98021;
	height: 65rpx;
	border-radius: 15rpx 15rpx 15rpx 15rpx;
	margin-top: 20rpx;
}

.bank-Text {
	text-align: center;
	margin-top: 10rpx;
	color: #fff;
}

button {
	width: 80%;
	margin-top: 20%;
	background-color: #f98021;
	color: #fff;
}
</style>
