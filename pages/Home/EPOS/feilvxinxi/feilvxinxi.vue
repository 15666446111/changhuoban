<template>
	<view>
		<view style="height: 20upx; background-color: #f1f1f1;"></view>
		<view class="d-flex">
			<view class="shuxian"></view>
			<view class="shoukuan">收款费率:</view>
		</view>
		<view style="margin-left:8% ;">0.6% 费率：交通/民生/招商/浦发</view>
		<view class="" style="margin-left:8% ;margin-top: 1%;">0.55% 费率：工商/中国/建设/光大/中信/华夏/广发
		/平安/上海/北京/恒丰/各区域性银行</view>
		<view class="d-flex">
			<view class="shuxian"></view>
			<view class="shoukuan">提现费用:</view>
		</view>
		<view style="margin-left:8% ; margin-top: 1%;">单笔2元提现费，可累计提现</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				
			}
		},
		methods: {
			
		}
	}
</script>

<style>
	page{
		background-color: #fff;
		color: #666;
	}
	.shuxian{
		width:3.5px;
		height: 25px;
		background-color: #FF0000;
		margin-left: 4%;
		margin-top: 10upx;
	}
	.shoukuan{
		margin-top: 8upx;
		font-size: 30upx;
		margin-left:3%;
		color: #333;
	}
		

</style>
