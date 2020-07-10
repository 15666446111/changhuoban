<template>
	<view>
		<view class="fr_top">
			<image class="fr_iamge" src="../../../../static/mark.png"></image>
			<view class="view_p">注：当保存参数后新参数即时生效。</view>
		</view>

		<!-- 结算价调整 -->
		<view class="body">
			<view class="view_h1"><view class="text">结算价参数</view></view>
			<view class="rule"></view>
			<!-- 信用卡 -->
			<view class="rule-view">
				<view class="rule_p">
					<view class="view_p2">信用卡</view>
					<input class="rule_input" placeholder="0.60%" placeholder-class="place" />
					<view class="view_s">0.53% ~ 0.60%</view>
				</view>
			</view>
			<view class="rule"></view>
			<!-- 借记卡  -->
			<view class="rule-view">
				<view class="rule_p">
					<view class="view_p2">借记卡</view>
					<input class="rule_input" placeholder="0.50%" placeholder-class="place" />
					<view class="view_s">0.45% ~ 0.50%</view>
					<input placeholder="20" class="rule_input1" placeholder-class="place2" />
					<view class="view_s">17~20</view>
				</view>
			</view>
			<view class="rule"></view>
			<!-- 二维码 双免 -->
			<view class="rule-view">
				<view class="rule_p">
					<view class="view_p2">二维码</view>
					<input class="rule_input" placeholder="0.38%" placeholder-class="place" />
					<view class="view_s">0.38% ~ 0.38%</view>
				</view>
			</view>
			<view class="rule"></view>
			<view class="rule-view">
				<view class="rule_p1">
					<view class="view_p2">双 免</view>
					<input class="rule_input" placeholder="0.38%" placeholder-class="place" />
					<view class="view_s">0.38% ~ 0.38%</view>
				</view>
			</view>
		</view>
		<!-- 返现设置 -->
		<view class="body2">
			<view class="view_h1"><view class="text">返现参数（元）</view></view>
			<view class="rule"></view>
			<view class="rule-view">
				<view class="rule_p">
					<view class="view_p2">激活返现</view>
					<input class="rule_input2" placeholder="200" placeholder-class="place" />
				</view>
			</view>
			<view class="rule"></view>

			<view class="rule-view">
				<view class="rule_p">
					<view class="view_p2">达标返现</view>
					<input class="rule_input2" placeholder="200" placeholder-class="place" />
				</view>
			</view>
			<view class="rule"></view>

			<view class="rule-view">
				<view class="rule_p">
					<view class="view_p2">活动返现</view>
					<input class="rule_input2" placeholder="200" placeholder-class="place" />
				</view>
			</view>
		</view>

		<navigator  hover-class="none"  url="jiaoyixiangqing/jiaoyixiangqing"><button class="button">确 认 修 改</button></navigator>
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
button {
	width: 70%;
	margin-left: 15%;
	margin-top: 100upx;
	background-color: #f0ad4e;
	color: #ffffff;
	font-weight: 800;
	border-radius: 7px 7px 7px 7px;
}
.fr_top {
	width: 100%;
	height: 80upx;
	background-color: #fff;
	overflow: hidden;
	display: flex;
	/* 	border-radius: 10px 10px 10px 10px; */
	box-shadow: #ddd 3px 3px 8px 3px;
	margin-top: 2%;
}
.view_p {
	font-size: 0.7rem;
	color: #666;
	width: 60%;
	margin-top: 2%;
	margin-left: 2%;
}

.fr_iamge {
	width: 1.4rem;
	height: 1.4rem;
	display: flex;
	margin-top: 1.2%;
	margin-left: 8%;
}
/* 调整信息 */
.body {
	width: 100%;
	background-color: white;
	margin-top: 2%;
	box-shadow: #ddd 3px 3px 8px 3px;
}

.view_h1 {
	text-align: center;
	height: 2rem;
	overflow: hidden;
}
.text {
	font-size: 0.9rem;
	margin-top: 2%;
}
.rule {
	width: 90%;
	height: 1px;
	background-color: #dbdada;
	margin-left: 5%;
}

/* 信用卡 */
.rule-view {
	width: 100%;
	height: 100%;
	overflow: hidden;
	height: 100upx;
}
.rule-view1 {
	width: 100%;
	height: 2.1rem;
	overflow: hidden;
}
.rule_p {
	display: flex;
	margin-top: 2%;
}
.rule_p1 {
	display: flex;
	margin-top: 2%;
	height: 80upx;
}
.view_p2 {
	width: 20%;
	text-align: center;
	font-size: 0.8rem;
	margin-left: 3%;
	margin-top: 1.5%;
}
.rule_input {
	width: 12%;
	background-color: #f1f1f1;
	border: 0;
	height: 1.3rem;
	font-size: 23upx;
	text-align: center;
	margin-top: 1.5%;
}
.rule_input1 {
	width: 8%;
	height: 1.3rem;
	background-color: #f1f1f1;
	text-align: center;
	border: 0;
	text-align: center;
	margin-left: 10%;
	font-size: 23upx;
	margin-top: 1.5%;
}
.view_s {
	color: #f98021;
	font-size: 0.6rem;
	margin-left: 2%;
	margin-top: 2%;
}
.view_p3 {
	text-align: center;
	width: 20%;
}
/**/
.body2 {
	width: 100%;
	background-color: white;
	margin-top: 2%;
	box-shadow: #ddd 3px 3px 8px 3px;
}
.rule_input2 {
	width: 17%;
	background-color: #f1f1f1;
	border: 0;
	height: 1.3rem;
	text-align: center;
	margin-left: 50%;
	color: #999;
	font-size: 28upx;
	margin-top: 1.5%;
}
#button-1 {
	width: 80%;
	background-color: #f98021;
	color: #fff;
	height: 2rem;
	margin-left: 10%;
	border: 0;
	border-radius: 0.3rem;
	margin-top: 2rem;
	font-size: 0.9rem;
}
</style>


