<template>
	<view>
		<image src="/static/assess_card.png" style="height: 300upx;"></image>
		<view class="content ">
			<view class="title">
				<text class="title-name">基本信息</text>
				<text style="color:#F43530; margin-left:400upx;">9.90</text>
				<text class="title-text">元</text>
			</view>
			<view class="xian"></view>
			<input class="select-text" placeholder="请输入手机号" placeholder-class="place" />
			<view class="xian"></view>
			<input class="select-text" placeholder="请输入身份证号" placeholder-class="place" />
			<view class="xian"></view>
			<input class="select-text" placeholder="请输入银行卡号" placeholder-class="place" />
			<view class="xian"></view>
			<input class="select-text" placeholder="请输入预留手机号" placeholder-class="place" />
			<view class="xian"></view>
			<view class="d-flex">
				<input class="select-text" placeholder="请输入验证码" placeholder-class="place" />
				<view class="auth"><text>获取验证码</text></view>
			</view>
			<view class="xian"></view>
			<view class="boxs">
				<checkbox>
					<text>我已阅读并同意</text>
					<text style="color: #F43530;">《用户协议》</text>
				</checkbox>
			</view>
			<view class="botton"><text>立即查询</text></view>

			<view class="zhushi" style="color: #F43530; position: relative; height: 100upx; line-height: 100upx;">
				<text style="margin-left: 40upx;">评测样式</text>
				<text style="position: absolute; right: 20upx;">我的评测订单 ></text>
			</view>
		</view>
		<view style="height: 30upx"></view>
		<view class="content">
			<view style="font-size: 30upx; margin-left: 20upx;">温馨提示:</view>
			<view class="context">1. 两个月内新卡请勿评测，负责查无结果</view>
			<view class="context">2. 近半年未做交易的卡请勿评测，负责查无结果</view>
			<view class="context">3. 卡测评产品会校验用户输入的四要素信息一致性，四要素不一致，不返回结果；</view>
			<view class="context">4. 历史订单有效期：3 个月。</view>
		</view>
	</view>
</template>

<script>
export default {
	components: {},
	data() {
		return {};
	},
	methods: {}
};
</script>

<style>
.content {
	width: 92%;
	margin-left: 4%;
	background-color: #fff;
	border-radius: 8px;
}
.xian {
	width: 92%;
	height: 1upx;
	background-color: #f1f1f1;
	margin-left: 4%;
}
.select-text {
	color: #666;
	height: 100upx;
	line-height: 100upx;
	margin-left: 35upx;
}
.title {
	width: 92%;
	height: 100upx;
	line-height: 100upx;
	margin-left: 35upx;
	font-size: 30upx;
}

.auth {
	border: 1upx solid #f43530;
	height: 60upx;
	width: 180upx;
	text-align: center;
	line-height: 60upx;
	color: #f43530;
	border-radius: 10upx;
	margin-top: 20upx;
}
.boxs {
	height: 100upx;
	line-height: 100upx;
	margin-left: 20upx;
	font-size: 28upx;
}
.botton {
	width: 80%;
	margin-left: 10%;
	background-color: #f43530;
	height: 70upx;
	line-height: 70upx;
	border-radius: 8upx;
	text-align: center;
	color: #fff;
}
.context {
	margin-left: 20upx;
	font-size: 26upx;
	color: #666;
	width: 90%;
}
</style>
