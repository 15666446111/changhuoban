<template>
	<view>
		<view class="shiming">
			<view class="renzheng">
				
				<view class="picture" @click="chooseimge('idcard_before')">
					<image :src="idcard_before" class="img" mode="widthFix" />
					<view class="name">身份征正面</view>
					<view class="text">（文字清晰,四角齐全）</view>
				</view>
				
				<view class="picture" @click="chooseimge('idcard_after')">
					<image :src="idcard_after" class="img" mode="widthFix" />
					<view class="name">身份征反面</view>
					<view class="text">（文字清晰,四角齐全）</view>
				</view>
			</view>
			<view class="renzheng">
				<view class="picture" @click="chooseimge('idcard_house')">
					<image :src="idcard_house" class="img" mode="widthFix" />
					<view class="name">手持身份证</view>
					<view class="text">（文字清晰,四角齐全）</view>
				</view>
				<view class="picture" @click="chooseimge('bank_before')">
					<image :src="bank_before" class="img" mode="widthFix" />
					<view class="name">银行卡正面</view>
					<view class="text">（文字清晰,四角齐全）</view>
				</view>
			</view>
		</view>
		
		<navigator url="shimingxinxi/shimingxinxi" class="url">
			<button class="button-1" id="button-1">下 一 步</button>
		</navigator>
		
	</view>
</template>

<script>
export default {
	data() {
		return {
			idcard_before : '/static/shuzi/IDcard.png',
			idcard_after: '/static/shuzi/IDcard2.png',
			idcard_house: '/static/shuzi/Idcard3.png',
			bank_before: '/static/shuzi/bank_card.png',
		};
	},
	methods: {
		// 选择图片上传
		chooseimge(index){
			uni.chooseImage({
				count: 1, //默认9
				sizeType: ['original', 'compressed'], //可以指定是原图还是压缩图，默认二者都有
				sourceType: ['album'], //从相册选择
				success: (res) => {
					uni.getImageInfo({
						src: res.tempFilePaths[0],
						success: (image) => {
							this.index = JSON.stringify(image.path);
							console.log(image);
						}
					});
					
					console.log(this.index)
					console.log(JSON.stringify(res.tempFilePaths));
				}
			});		
		}
	
	}
};
</script>

<style>
@import '../style/realname.css';
</style>
