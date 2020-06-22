<template>
	<view class="body">
		<view class="orderform">MP70(3台)订单：畅伙伴</view>
		<view class="money">¥ 594.00</view>
		<view class="xian"></view>
		<view class="payee">
			<view class="payee-text">收款方</view>
			<view class="payee-name">畅伙伴</view>
		</view>
		<view class="xian"></view>
		<view class="button">
		  <view class="button-text">立 即 支 付</view>
		</view>
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
		background-color:#fff;
		height: 400rpx;
		margin-top: 2%;
		overflow: hidden;
		
	}
.orderform {
  text-align: center;
  font-weight: 600;
  font-size: 30rpx;
  margin-top: 20rpx;
}

.money {
  text-align: center;
  margin-top: 20rpx;
  font-weight: 600;
  font-size: 40rpx;
  height: 80rpx;
}

.xian {
  width: 100%;
  height: 1px;
  background-color: #c5c3c3;
}

.payee {
  width: 90%;
  margin-left: 5%;
  height: 80rpx;
  display: flex;
}

.payee-text {
  font-size: 28rpx;
  color: #666;
  margin-top: 20rpx;
}

.payee-name {
  font-size: 28rpx;
  color: #666;
  margin-top: 20rpx;
  margin-left: 500rpx;
}

.button {
  background-color: #FF8C00;
  width: 80%;
  margin-left: 10%;
  margin-top: 40rpx;
  height: 80rpx;
  overflow: hidden;
  border-radius: 7px 7px 7px 7px;
}

.button-text {
  color: #fff;
  text-align: center;
  margin-top: 15rpx;

}
</style>
