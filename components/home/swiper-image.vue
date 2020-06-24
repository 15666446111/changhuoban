<template>
	<view>
		<!-- 轮播图 -->
		<swiper :indicator-dots="true" :autoplay="true" :interval="3000" :duration="1000" circular>
			<block v-for="(item,index) in resdata" :key="index">
				<swiper-item class="swit">
					<view class="swiper-item">
						<image :src="item.images" lazy-load style="height: 350upx;"></image>
					</view>
				</swiper-item>
			</block>
		</swiper>
	</view>
</template>
<script>
	
	export default{
		props:{
			resdata: Array
		}
	}
	
</script>

<style>
swiper {
	width: 92%;
	margin-left: 4%;
	margin-top: 2%;
}

.swit {
	border-radius: 20upx;
}
.swiper-item {
	border-radius: 20upx;
}
</style>
