<template>
	<view class="body">
		<view class="top">
		  <image src="../../../../static/left_fdj.png" class="img"></image>
		  <input class="input" placeholder="" />
		</view>
		<view class="line"></view>
		
		<view class="bview">
		  <image src="../../../../static/bj.png" class="bank"></image>
		  <view class="bank_name">北京银行</view>
		</view>
		<view class="line1"></view>
		
		<view class="bview">
		  <image src="../../../../static/gs.png" class="bank"></image>
		  <view class="bank_name">工商银行</view>
		</view>
		<view class="line1"></view>
		
		<view class="bview">
		  <image src="../../../../static/gd.png" class="bank"></image>
		  <view class="bank_name">光大银行</view>
		</view>
		<view class="line1"></view>
		
		<view class="bview">
		  <image src="../../../../static/gf.png" class="bank"></image>
		  <view class="bank_name">广发银行</view>
		</view>
		<view class="line1"></view>
		<!--  -->
		<view class="bview">
		  <image src="../../../../static/hx.png" class="bank"></image>
		  <view class="bank_name">华夏银行</view>
		</view>
		<view class="line1"></view>
		
		<view class="bview">
		  <image src="../../../../static/js.png" class="bank"></image>
		  <view class="bank_name">建设银行</view>
		</view>
		<view class="line1"></view>
		
		<view class="bview">
		  <image src="../../../../static/jt.png" class="bank"></image>
		  <view class="bank_name">交通银行</view>
		</view>
		<view class="line1"></view>
		
		<view class="bview">
		  <image src="../../../../static/minsheng.png" class="bank"></image>
		  <view class="bank_name">民生银行</view>
		</view>
		<view class="line1"></view>
		
		<view class="bview">
		  <image src="../../../../static/ny.png" class="bank"></image>
		  <view class="bank_name">农业银行</view>
		</view>
		<view class="line1"></view>
		
		<!--  -->
		<view class="bview">
		  <image src="../../../../static/pa.png" class="bank"></image>
		  <view class="bank_name">平安银行</view>
		</view>
		<view class="line1"></view>
		
		<view class="bview">
		  <image src="../../../../static/pf.png" class="bank"></image>
		  <view class="bank_name">浦发银行</view>
		</view>
		<view class="line1"></view>
		
		<view class="bview">
		  <image src="../../../../static/sh.png" class="bank"></image>
		  <view class="bank_name">上海银行</view>
		</view>
		<view class="line1"></view>
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
	.body{
		width: 100%;
		height: 100%;
		background-color: #fff;
	}
.top {
  width: 86%;
  height: 60rpx;
  margin: 0 auto;
  border-radius: 40rpx;
  background-color: rgb(230, 230, 230);
  display: flex;
  position: relative;
  margin-bottom: 8rpx;
}

.img {
  width: 48rpx;
  height: 48rpx;
  position: absolute;
  top: 6rpx;
  left: 30rpx;
}

.input {
  margin-left: 90rpx;
  height: 60rpx;
  width: 80%;
}

.line {
  width: 94%;
  height: 2rpx;
  background-color: rgb(226, 226, 226);
  margin: 0 auto;
}

.bank {
  width: 50rpx;
  height: 50rpx;
}

.bview {
  display: flex;
}

.bank {
  margin: 20rpx 20rpx 20rpx 40rpx;
}

.bank_name {
  margin: 24rpx 0 20rpx 60rpx;
}

.line1 {
  width: 94%;
  height: 2rpx;
  background-color: rgb(226, 226, 226);
  margin: 0 auto;
}
</style>
