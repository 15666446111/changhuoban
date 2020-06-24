<template>
	<view class="body">
		<view class="container2">
			<swiper class="sw">
				<swiper-item><image mode="aspectFit" :src=images class="img"></image></swiper-item>
			</swiper>
		</view>
		<button @click="save">长按图片保存</button>
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
	    	net({
	        	url:"/V1/temail_share",
	            method:'get',
	            success: (res) => {
					console.log(res);
					this.images = res.data.success.data.link;
	            }
	      	})
		},
		
		save(){
			uni.downloadFile({
				url: this.images,
				success: (res) =>{
					if (res.statusCode === 200){
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
			})
		}
	},
};
</script>


<style>
@import '../style/team_ext.css';
</style>