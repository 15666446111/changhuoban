<template>
	<view style="height: 100%">
		<view class="container2" style="flex:1" v-if="this.images">
			<swiper class="sw">
				<swiper-item><image mode="aspectFit" @longpress="downloadImg(images)" :src=images class="img"></image></swiper-item>
			</swiper>
			<button>长按图片保存</button>
		</view>
		
		<view style="height: 100%;  display: flex; justify-content: center;align-items: center; background-color: #f5f5f5;" v-if="!this.images">
			<image src="/static/no-data.jpeg" mode="widthFix"></image>
		</view>
	</view>
</template>

<script>
import net from '../../../common/net.js';

export default {
	data() {
		return { images: "images" , data: true};
	},
	
	onLoad() {
		uni.showLoading()
		this.getMerchantPic();
	},
	
	methods: {
		// 获取分享图
		getMerchantPic(){

	    	net({
	        	url:"/V1/merchant_share",
	            method:'get',
	            success: (res) => {
					uni.hideLoading()
					if (res.data.success && res.data.success.data.link) { 
						this.images = res.data.success.data.link;
					} else {
						this.images = null
						uni.showToast({ title: res.data.error.message, icon: 'none', position: 'bottom'})
					}
	            }
	      	})
		},
		
		// 长按保存图片
		downloadImg(imageUrl){
			uni.downloadFile({
			    url: imageUrl,
			    success: (res) => {
			        if (res.statusCode === 200) {
						uni.saveImageToPhotosAlbum({
							filePath: res.tempFilePath,
							success: function() {
								uni.showToast({ title: "保存成功", icon: "none" });
							},
							fail: function() {
								uni.showToast({ title: "保存失败，请稍后重试", icon: "none" });
							}
						});
					}
			    }
			});
		}
	},
};
</script>


<style>
@import '../style/team_ext.css';
</style>