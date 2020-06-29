<template>
	<view>
		<view class="top">
			<view class="text bview d-flex">
				昵称：<input class="qbtxje" placeholder="请输入昵称" v-model="UserInfo.nickname" />
			</view>
		</view>
		
		<button class="button" @click="setUserInfo">修改</button>
	</view>
</template>

<script>
	import net from '../../../common/net.js';
	export default {
		data() {
			return {
				UserInfo:[]
			}
		},
		onLoad() {
			// 获取用户个人信息
			this.getUserInfo();
		},
		methods: {
			// 获取用户个人信息
				getUserInfo(){
					net({
			        	url:"/V1/mine",
			            method:'get',
			            success: (res) => {
							console.log(res);
							this.UserInfo = res.data.success.data;
			            }
			      	})
				},
				
				setUserInfo(){
					net({
			        	url:"/V1/setUserInfo",
			            method:'get',
						data:{nickname:this.UserInfo.nickname},
			            success: (res) => {
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
