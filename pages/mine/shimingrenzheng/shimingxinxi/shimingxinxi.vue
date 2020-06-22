<template>
	<view>
		<view class="head">
			<view class="xinxi">
				<view class="text-name">
					<view class="text">持卡人</view>
					<input class="name" placeholder="畅伙伴" placeholder-class="place" />
				</view>
			</view>
			<view class="xinxi">
				<view class="text-name">
					<view class="text">身份征号</view>
					<input class="name" placeholder="370784111122223333" placeholder-class="place" />
				</view>
			</view>
			<view class="xinxi">
				<view class="text-name">
					<view class="text">结算银行</view>
					<input class="name" placeholder="浦发银行" placeholder-class="place" />
				</view>
			</view>
			<view class="xinxi">
				<view class="text-name">
					<view class="text">结算卡号</view>
					<input class="name" placeholder="6222 0000 0000 0000 000" placeholder-class="place" />
				</view>
			</view>
		</view>
		
		<navigator url="../xiangqing/xiangqing" open-type="navigate" class="url">
			<button>确认提交</button>
		</navigator>
	</view>
</template>

<script>
export default {
	data() {
		return {
			
		};
	},
	
	methods: {
		
	}
};

</script>

<style>
@import '../../style/realname_detail.css';
</style>
