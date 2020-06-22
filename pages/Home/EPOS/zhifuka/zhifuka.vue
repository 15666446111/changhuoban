<template>
	<view>
		
		<view class="gy-jsk">
			<view style="height: 25upx; background-color: #f1f1f1;"></view>
			<view class="gy-jiesuanka">
				<image src="/static/gs.png" style="width:80upx; height:80upx; margin-top:15upx; margin-left: 30upx; "></image>
				<view class="gy-jiesunka-view">
					<view class="gy-jiesunka-name">工商银行</view>
					<view class="gy-jiesunka-text" style="font-size: 28upx; color: #666666;">(6222)</view>
				</view>
				<image src="/static/EPOS/shanchu.png" style="width:50upx; height:50upx; margin-top:26upx;"></image>
			</view>
			<view class="xian"></view>
			<checkbox class="radio">设为默认</checkbox>
		</view>
		
	    <view class="kongge"></view>
		<view class="" style="position: relative; height:80upx; line-height:80upx;">
			<navigator url="../tianjiayinhangka/tianjiayinhangka">
			<text style="margin-left: 30upx; color: #666; ">添加新的支付卡</text>
			<image src="/static/EPOS/jiantou.png"
			 style="width:40upx; height:40upx; position: absolute; right: 30upx; bottom:15upx;"></image>
			</navigator>
			<view class="xian"></view>
			
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
page {
	background-color: #fff;
}
.gy-jiesuanka {
	display: flex;
	height: 130upx;
}
.xian {
	background-color: #f1f1f1;
	height: 1upx;
	width: 96%;
	margin-left: 2%;
}
.gy-jiesunka-view {
	width: 70%;
	margin-left: 20upx;
	color: #333;
	margin-top: 10upx;
}
.radio {
	position: absolute;
	right: 50upx;
}
.kongge {
	width: 100%;
	height: 25upx;
	background-color: #f1f1f1;
	margin-top:60upx;
}
</style>
