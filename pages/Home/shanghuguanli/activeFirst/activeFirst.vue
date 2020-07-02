<template>
	<view>
		<view style="height:20upx;"></view>
		<view class="head">
			<!--<view class="head-cash">押金</view>-->
			<view class="head-money">总交易金额(元)</view>
			<view class="head-text">{{ data.countTradeMoney }}</view>
		</view>


		<view class="title">
			<text class="title-name">首次</text>
			<text class="title-text">达标截止时间:2019-12-09 10:17:39</text>
		</view>
		<view style="height: 100%; background-color: #fff;">
			<view class="d-flex">
				<text class="title-text1">达标返现活动状态</text>
				<text class="title-text">已达标</text>
			</view>
			<view class="d-flex">
				<text class="title-text1">达标返现金额:</text>
				<text class="title-text">49</text>
			</view>
		</view>


		<text class="bot">{{ data.tips }}</text>
	</view>
</template>

<script>
import net from '../../../../common/net.js';
export default {

	data() {
		return {
			data: [],
		};
	},
	
	onLoad(options) {
		// 获取商户详细信息
		this.getMerchantActiveInfo(options.terminal);
	},
	
	methods: {
		
		getMerchantActiveInfo(tid){
			
			net({
				url: '/V1/getTerminalActiveDetail',
				method: 'GET',
				data:{ terminal:tid },
				success: (res) => {
					if(res.data.success){
						this.data = res.data.success.data;
					}
					console.log(res)
				}
			})
		}
		
	}
};
</script>

<style>
/*  */
.d-flex {
	height: 70upx;
	line-height: 70upx;
	font-size: 28upx;
}
.title-text1 {
	margin-left: 40upx;
	color: #333;
}
/* 抬头 */
.head {
	width: 100%;
	height: 300upx;
	background-color: #fff;
	position: relative;
	overflow: hidden;
	text-align: center;
}
.head-cash {
	width: 80upx;
	height: 80upx;
	background-color: #f0ad4e;
	border-radius: 50upx;
	text-align: center;
	line-height: 80upx;
	color: #fff;
	font-size: 30upx;
	position: absolute;
	left: 40upx;
	top: 20upx;
}
.head-money {
	margin-top: 9%;
	font-size: 30upx;
	color: #666;
}
.head-text {
	font-size: 60upx;
	font-weight: 800;
	margin-top: 20upx;
}
/* 第一标题 */
.title {
	width: 100%;
	height: 100upx;
	line-height: 100upx;
	font-size: 28upx;
	color: #666;
	position: relative;
}

.title-name {
	margin-left: 40upx;
}
.title-text {
	position: absolute;
	right: 40upx;
	color: #666;
}
.bot {
	position: fixed;
	bottom: 10upx;
	font-size: 25upx;
	color: #666;
	text-align: center;
	left: 60upx;
}
</style>
