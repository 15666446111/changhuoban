<template>
	<view class="bg">
		
		<view v-for="(item, index) in list" :key="index" class="list">
			
			<view class="title">
				{{ item.title }}
			</view>
			
			<view class="text">
				<rich-text :nodes="item.content"></rich-text>
			</view>
			
			<view class="edit">
				<text class="edittext" @click="share">立即分享</text>
				<text class="edittext right">查看全文</text>
			</view>
			
		</view>
		
	</view>
</template>

<script>
	import net from '../../../common/net.js';
	
	export default {
		
		data() {
			return {
				list: [],
			}
		},

		// 初始化数据
		onLoad(){
			uni.showLoading();
			this.getShareList();
		},
		
		methods: {
			// 获取个人信息
		  	getShareList(){
		    	net({
		        	url:"/V1/wx_share_list",
		            method:'get',
		            success: (res) => {
						uni.hideLoading();
						console.log(res);
						this.list = res.data.success.data;
		            }
		      	})
			},
			
			
			share(){
				uni.share({
					provider: "weixin",
					scene: "WXSenceTimeline",
					type: 1,
					summary: "我正在使用HBuilderX开发uni-app，赶紧跟我一起来体验！",
					success: function (res) {
						console.log("success:" + JSON.stringify(res));
					},
					fail: function (err) {
						console.log("fail:" + JSON.stringify(err));
					}
				});
			}
			
		}
		
	}
</script>

<style>
	.bg{
		background-color: #EEEEEE;
	}
	
	.list{width: 100%; height: auto; background-color: white;}
	.title{padding: 30rpx;}
	.text{ padding: 0rpx 30rpx; padding-bottom: 30rpx;}
	.edit{padding: 10rpx 30rpx;}
	.edittext{color: #007BFF; cursor: pointer;}
	.right{float: right;}
</style>
