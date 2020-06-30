<template>
	<view class="body">
		<view class="container2">
			<swiper class="sw">
				<swiper-item><image mode="aspectFit" @longpress="downloadImg(images)" :src=images class="img"></image></swiper-item>
			</swiper>
		</view>
		<button>长按图片保存</button>
	</view>
</template>

<script>
import net from '../../../common/net.js';

export default {
	data() {
		return {
			images: ''
		};
	},
	
	onLoad() {
		this.getMerchantPic();
	},
	
	methods: {
		// 获取分享图
		getMerchantPic(){
			
			console.log(uni.getStorageSync('token'));
	    	net({
	        	url:"/V1/merchant_share",
	            method:'get',
	            success: (res) => {
					if (res.data.success) {
						this.images = res.data.success.data.link;
					} else {
						uni.showToast({
							title: res.data.error.message,
							icon: 'none'
						})
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