<template>
	<view>
		<view class="selects">
			<view class="select"></view>
			<view class="select">
				<view class="select-view">
					<view class="select-name">姓名</view>
					<view  class="gy-select-text"  >畅伙伴</view>
				</view>
				<view class="hengxian"></view>
				<view class="select-view">
					<view class="select-name">身份证号</view>
					<view class="gy-select-text">370784111111111111</view>
				</view>
			</view>
		</view>
		<!-- 信息填写 -->
		<view class="selects">
			<view class="select"></view>
			<view class="select">
				<view class="select-view">
					<view class="select-name">银行名称</view>
					<input class="select-text" placeholder="请选择银行名称" placeholder-class="place" />
				</view>
				<view class="hengxian"></view>
				<view class="select-view">
					<view class="select-name">银行卡号</view>
					<input class="select-text" placeholder="请输入银行卡号" placeholder-class="place" />
				</view>
				<view class="hengxian"></view>
				<view class="select-view">
					<view class="select-name">手机号</view>
					<input class="select-text" placeholder="请输入手机号" placeholder-class="place" />
				</view>
				<view class="hengxian"></view>
				<view class="select-view1">
					<view class="select-name">验证码</view>
					<input class="select-text1" placeholder="请输入验证码" placeholder-class="place" />
					<view class="select-text2">获取验证码</view>
				</view>
				<view class="hengxian"></view>
				<view class="select-view">
					<view class="select-name">信用卡期限</view>
					<input class="select-text" placeholder="请选择有效期" placeholder-class="place" />
				</view>
			</view>
			<view class="hengxian"></view>
			<checkbox class="radio">设为默认</checkbox>
		</view>
		<navigator url="../querenxinxi/querenxinxi"><button id="button-1">下 一 步</button></navigator>
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
	.radio {
	height: 80upx;
	line-height: 80upx;
	margin-left: 40upx;
	}
/* 填写信息 */
.selects {
	width: 100%;
	background-color: #fff;
	margin-top: 2%;
	box-shadow: #ddd 3px 3px 8px 3px;
}

.select-view {
	display: flex;
	height: 90rpx;
	position: relative;
}
.select-view1 {
	display: flex;
	height: 90rpx;
	position: relative;
}

.select-image {
	width: 1.4rem;
	position: absolute;
	right: 1rem;
	top: 0.3rem;
}

.select-name {
	font-size: 0.8rem;
	margin-left: 1rem;
	margin-top: 3%;
	width: 25%;
}

.select-text {
	color: #666;
	font-size: 0.7rem;
	border: 0;
	margin-left: 1rem;
	margin-top: 4%;
}
.gy-select-text{
	color: #666;
	font-size: 0.7rem;
	border: 0;
	margin-left: 1rem;
	margin-top: 3%;
	}
.select-text1 {
	color: #666;
	font-size: 0.7rem;
	border: 0;
	margin-left: 1rem;
	margin-top: 4%;
	width: 30%;
}
.select-text2 {
	color: #f64547;
	font-size: 0.6rem;
	border: 0;
	margin-left: 1rem;
	margin-top: 3%;
}
.hengxian {
	width: 94%;
	height: 1px;
	background-color: #dbdada;
	margin-left: 3%;
}

/* 按钮 */

button {
	width: 80%;
	background: linear-gradient(to right, #fe695a, #f64547);
	color: #fff;
	height: 85rpx;
	margin-left: 10%;
	border: 0;
	border-radius: 0.3rem;
	margin-top: 2rem;
	font-size: 0.9rem;
}
</style>
