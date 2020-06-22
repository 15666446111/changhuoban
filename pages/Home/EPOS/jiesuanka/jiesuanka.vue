<template>
	<view>
		
		<view class="gy-jsk">
			<view style="height: 25upx; background-color: #f1f1f1;"></view>
			<view class="gy-jiesuanka">
				<image src="/static/gs.png" style="width:80upx; height:80upx; margin-top:20upx; margin-left: 30upx; "></image>
				<view class="gy-jiesunka-view">
					<view class="gy-jiesunka-name">工商银行</view>
					<view class="gy-jiesunka-text" style="font-size: 28upx; color: #666666;">(6222000000000000000)</view>
				</view>
				<image src="/static/EPOS/edit_red.png" style="width:50upx; height:50upx; margin-top:35upx;"></image>
			</view>
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
	margin-top: 15upx;
}
</style>
