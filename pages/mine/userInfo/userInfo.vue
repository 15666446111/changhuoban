<template>
	<view>
		<view class="top">
			<view class="text bview d-flex">
				昵称：<input class="qbtxje" placeholder="请输入昵称" v-model="UserInfo.nickname" />
			</view>
		</view>
		
		<button class="button" @click="setUserInfo">修改</button>
		
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
					text: '提交中...'
				},
				UserInfo:[]
			}
		},
		onLoad() {
			this.loadModal.show = true;
			// 获取用户个人信息
			this.getUserInfo();
		},
		methods: {
			// 获取用户个人信息
				getUserInfo(){
					net({
			        	url:"/V1/userInfo",
			            method:'get',
			            success: (res) => {
							this.loadModal.show = false;
							this.UserInfo = res.data.success.data;
			            }
			      	})
				},
				
				setUserInfo(){
					this.loadModal.show = true;
					net({
						url:"/V1/setUserInfo",
						method:'get',
						data:{ nickname:this.UserInfo.nickname },
						success: (res) => {
						this.loadModal.show = false;
							if (res.data.success) {
								uni.showToast({
									title: res.data.success.message,
									icon: 'none',
									success : function(){
										setTimeout(function() {
											uni.navigateBack();
										}, 1500);
									}
								});
							} else {
								uni.showToast({
									title: res.data.error.message,
									icon: 'none'
								});
							}
			            }
			      	})
				}
				
		}
	}
</script>

<style>
	@import '../../../common/uni.css';
	@import url("../style/cash-out.css");
</style>
