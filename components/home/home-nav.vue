<template>
	<view class="row j-center py-2 m-2">
		<block v-for="(item, index) in resdata" :key="index">
			<navigator  hover-class="none" :url="item.url" class="span-5 d-flex flex-column j-center a-center py-1" @tap="envent(item)">
				<image :src="item.src" mode="widthFix" style="width: 80upx; height: 80upx;"></image>
				<text class="font-sm">{{ item.text }}</text>
			</navigator>
		</block>
	</view>
</template>

<script>
export default {
	props: {
		resdata: Array
	}
};
</script>

<style></style>
