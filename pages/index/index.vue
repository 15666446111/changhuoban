<template>
	<view>
		<view class="logo-view">
			<image class="logo" src="/static/index/logo.png"></image>
		</view>
		
		<view class="user-name">
			<view class="user-name-view">
				<view class="iconfont iconmobile"></view>
				<input class="user-inpu" placeholder="请输入用户账号" type="number" v-model="account" />
			</view>
			<view class="user-name-view">
				<view class="iconfont iconlock"></view>
				<input class="user-inpu" placeholder="请输入密码" password="true" v-model="password" />
			</view>
		</view>
		
		<view class="checkbox">
			<checkbox-group>
				<checkbox checked="true"></checkbox>记住密码
			</checkbox-group>
		</view>
		
		<button class="loginButton" @click="submit">立即登录</button>
		
		<navigator  hover-class="none"  url="forgetPassword">
			<view class="d-flex">
				<view class="d-box">
					<view class="forget">忘记密码？</view>
				</view>
			</view>
		</navigator>
		
		<view class="cu-load load-modal" v-if="loadModal.show">
		   <!-- <view class="cuIcon-emojifill text-orange"></view> -->
		   <image src="/static/public/loading.png" mode="aspectFit"></image>
		   <view class="gray-text">{{ loadModal.text }}</view>
		</view>
	</view>
	
	
</template>

<script>
import uniPopup from '@/components/uni-popup/uni-popup.vue'

export default {
	
	components: {uniPopup},
	
	data() {
		return {
			loadModal: {
				show: false,
				text: '登陆中..'
			},
			
			account: '',
			password: '',
			applyText: '<div>345</div>',
			//验证规则
			rules: {
				// account: [
				// 	{
				// 		rule: /^1[356789]\d{9}$/,
				// 		msg: '手机号格式不正确'
				// 	}
				// ],
				password: [
					{
						rule: /^.{6,16}$/,
						msg: '密码格式不正确，长度为6-16个字符'
					}
				]
			}
		};
	},
	methods: {
		apply(){
			this.$refs.popup.open()
		},
		
		//表单验证
		validate(key) {
			var check = true;
			this.rules[key].forEach(v => {
				//验证失败
				if (!v.rule.test(this[key])) {
					uni.showToast({
						title: v.msg,
						icon: 'none'
					});
					check = false;
					return false;
				}
			});
			return check;
		},
		//提交表单
		submit() {
			//验证用户名  验证密码
			if (!this.validate('password') ) return false; 
			this.loadModal = { show: true, text: '登录中...' }
			
			uni.request({
				url: 'http://livechb3.changhuoban.com/api/V1/login',
				method: 'POST',
				data: {
					account: this.account,
					password: this.password
				},
				success: res => {
					
					console.log(res);
					this.loadModal.show = false;
					try {
						if (res.data.success && res.data.success.token) {
							uni.setStorageSync('token', res.data.success.token);
							uni.setStorageSync('operate', res.data.success.operate);
							uni.setStorageSync('type', res.data.success.type);
							uni.showToast({ title: '登录成功', icon: 'none', position: 'bottom' });
							uni.switchTab({ url: '/pages/Home/home' });
						} else {
							uni.showToast({ title: res.data.error.message, icon: 'none' });
						}
					} catch (e) {
						uni.showToast({ title: '网络错误,请重试', icon: 'none' });
					}
				},
				fail: () => {},
				complete: () => {}
			});
		}
	}
};
</script>

<style>
@import 'style/index.css';
</style>
