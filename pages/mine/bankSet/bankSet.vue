<template>
	<view class="bank-card">
		<navigator url="updatePwd/updatePwd" open-type="navigate">
			<view class="bank">
				<view class="bank-name">修改登录密码</view>
				<image class="bank-img" src="../../../static/jiantou.png" mode="widthFix" />
			</view>
		</navigator>
		<view class="add-xian"></view>
		<navigator url="../cash/bankList/bankList" open-type="navigate">
			<view class="bank">
				<view class="bank-name">结算信息管理</view>
				<image class="bank-img" src="../../../static/jiantou.png" mode="widthFix" />
			</view>
		</navigator>
		<navigator url="../../Home/shangcheng/dizhi/dizhi" open-type="navigate">
			<view class="bank">
				<view class="bank-name">收货地址管理</view>
				<image class="bank-img" src="../../../static/jiantou.png" mode="widthFix" />
			</view>
		</navigator>
		<navigator url="../userInfo/userInfo" open-type="navigate">
			<view class="bank">
				<view class="bank-name">个人信息管理</view>
				<image class="bank-img" src="../../../static/jiantou.png" mode="widthFix" />
			</view>
		</navigator>
		<view class="add-xian"></view>
		
		<button class="psy" @click="logout">退出登录</button>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				
			}
		},
		methods: {
			logout(){
				uni.removeStorageSync('token');
				uni.removeStorageSync('operate');
				uni.showToast({
					title: '退出成功',
					icon: 'none',
					success() {
						setTimeout(function() {
							uni.reLaunch({
								url: '../../index/index'
							})
						}, 1500);
					}
				})
			}
		}
	}
</script>

<style>
@import '../style/setting.css';
</style>
