<template>
	<view>
		<view class="back">
			<view class="view">
				<navigator  hover-class="none"  url="../policGet/policGet">
					<view class="policy">
						<view class="model">选择回拨机具政策</view>
						<view class="amount" v-if="policyInfo.id == undefined">请选择</view>
						<view class="amount" v-else>{{policyInfo.title}}</view>
						<image class="model-image" src="/static/jiantou.png" mode="widthFix"></image>
					</view>
				</navigator>
			</view>
			<view class="view">
				<navigator  hover-class="none"  url="../friendsGet/friendsGet">
				<view class="policy">
					<view class="model">选择回拨伙伴</view>
					<view class="amount" v-if="partnerInfo.id == undefined">请选择</view>
					<view class="amount" v-else>{{partnerInfo.nickname}} - {{partnerInfo.account}}</view>
					<image class="model-image" src="/static/jiantou.png" mode="widthFix"></image>
				</view>
				</navigator>
			</view>
			<view class="bottom">
				<view class="bview">
					<!-- <view class="cancel"><view>区间划拨</view></view> -->
					<view class="cancel" style="width: 100%;" @click="transfer">选择回拨</view>
				</view>
			</view>
		</view>
	</view>
</template>

<script>
export default {
	data() {
		return {
			policyInfo: {},
			partnerInfo: {},
		};
	},
	
	onLoad() {
		
	},
	methods: {
		transfer(){
			if (this.partnerInfo.id == undefined) {
				uni.showToast({
					title: '请选择回拨伙伴',
					icon: 'none'
				})
				return false;
			}
			if (this.policyInfo.id == undefined) {
				uni.showToast({
					title: '请选择回拨机具政策',
					icon: 'none'
				})
				return false;
			}
			uni.navigateTo({
				url: '../xuanzehuabo/opt_call_back?policy_id=' + this.policyInfo.id + '&uid=' + this.partnerInfo.id
			})
		}
	}
};
</script>

<style>
@import url("../../style/transfer.css");
</style>
