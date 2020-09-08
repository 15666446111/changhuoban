<template>
	<view>
		<view class="view" v-if="policy.length != 0">
			<view v-for="(item,index) in policy" :key="index" @click="optPolicy(item)">
				<view class="policy">
					<view class="model">
						<text class="model-text">{{item.title}}</text>
					</view>
					<!-- <view class="amount"></view> -->
					<image class="model-image" src="/static/jiantou.png" mode="widthFix"></image>
				</view>
				<view class="xian"></view>
			</view>
		</view>
		
		<view v-if="policy.length == 0" style="padding-top: 200rpx; color:#999; font-size: 32rpx; text-align: center;">
			暂无可选的活动～
		</view>
		
		<view class="cu-load load-modal" v-if="loadModal.show">
		   <image src="/static/public/loading.png" mode="aspectFit"></image>
		   <view class="gray-text">{{ loadModal.text }}</view>
		</view>
	</view>
</template>

<script>
import net from '../../../../common/net.js';
export default {
	data() {
		return {
			loadModal: {
				show: false,
				text: '加载中...'
			},
			policy: []
		};
	},
	
	onLoad() {
		this.loadModal.show = true;
		this.getPolicyList();
	},
	methods: {
		// 获取政策信息
		getPolicyList(){
			net({
	        	url:"/V1/getPolicy",
	            method: 'get',
	            success: (res) => {
					this.loadModal.show = false;
					if(res.data.success && res.data.success.data)
						this.policy = res.data.success.data;
					else
						uni.showToast({ title: res.data.error.message, icon: 'none' });
	            }
	      	})
		},
		
		// 选择政策并跳转
		optPolicy(item) {
			var pages = getCurrentPages();
			var prevPage = pages[pages.length - 2]; //上一个页面
			
			var data = {
				id : item.id,
				title : item.title,
			};
			prevPage.$vm.policyInfo = data;
			uni.navigateBack();
		}
	}
};
</script>

<style>
@import url("../../style/policy_opt.css");
</style>
