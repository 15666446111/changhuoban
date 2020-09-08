<template>
	<view class="bg">
		
		<view v-for="(item, index) in list" :key="index" class="list">
			
			<view class="title">
				{{ item.title }}
			</view>
			
			<view class="img">
				<image class="thumbnail" :src=item.images mode="widthFix"></image>
			</view>
			
			<view class="text">
				<rich-text :nodes="item.content"></rich-text>
			</view>
			
			<view class="edit">
				<text class="edittext" @click="share(item.content, item.images)">立即分享</text>
			</view>
			
		</view>
		
		<view class="cu-load load-modal" v-if="loadModal.show">
		   <image src="/static/public/loading.png" mode="aspectFit"></image>
		   <view class="gray-text">{{ loadModal.text }}</view>
		</view>
	</view>
</template>

<script>
	import net from '../../../common/net.js';
	
	export default {
		
		data() {
			return {
				loadModal: {
					show: false,
					text: '加载中...'
				},
				list: [],
			}
		},

		// 初始化数据
		onLoad(){
			this.loadModal.show = true;
			this.getShareList();
		},
		
		methods: {
			// 获取分享信息
		  	getShareList(){
		    	net({
		        	url:"/V1/wx_share_list",
		            method:'get',
		            success: (res) => {
						this.loadModal.show = false;
						console.log(res);
						this.list = res.data.success.data;
		            }
		      	})
			},
			
			share(text, images){
				var dd=text.replace(/<\/?.+?>/g,"");
				var dds=dd.replace(/ /g,"");
				uni.setClipboardData({ data: dds });
				uni.share({
					provider: "weixin",
					scene: "WXSenceTimeline",
					type: 2,
					imageUrl: images,
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
	
	.list{width: 100%; height: auto; background-color: white; margin-top: 16rpx;}
	.title{padding: 30rpx;}
	.text{ padding: 0rpx 30rpx; padding-bottom: 30rpx;}
	.edit{padding: 10rpx 30rpx;}
	.edittext{color: #007BFF; cursor: pointer;}
	.right{float: right;}
	.img {padding: 30rpx;}
	.thumbnail { width: 200rpx;}
</style>
