<template>
	<view>
		
		<view class="logo-view">
			<image class="logo" src="/static/index/logo.png"></image>
		</view>
		
		<view class="user-name">
			
			<view class="user-name-view">
				<view class="iconfont iconmobile"></view>
				<input class="user-inpu" placeholder="请输入您的登陆账号" type="number" v-model="account" />
			</view>
			
			<view class="user-name-view">
				<view class="iconfont iconsafetycertificate"></view>
				<input class="user-inpu" placeholder="动态验证码" type="number"  v-model="code" />
				<view class="auth" v-model="code" @click="getCode">{{codeTime>0?codeTime+'s后发送' : "获取验证码"}}</view>
			</view>
			<view class="user-name-view">
				<view class="iconfont iconlock"></view>
				<input class="user-inpu" placeholder="请输入6-16位密码" password="true" v-model="password" />
			</view>
			<view class="user-name-view">
				<view class="iconfont iconlock"></view>
				<input class="user-inpu" placeholder="请再次输入密码" password="true" v-model="confirmPassword" />
			</view>
		</view>
		
		<button class="registerButton" @click="submit">立即重置</button>
		
	</view>
</template>

<script>
export default {
	data() {
		return {
			code:'',
			codeTime:0,
			account: '',
			password: '',
			confirmPassword: '',
			
			//验证规则
			rules: {
				account: [
					{
						rule: /^1[356789]\d{9}$/,
						msg: '手机号格式不正确'
					}
				],
				password: [
					{
						rule: /^.{6,16}$/,
						msg: '密码格式不正确，长度为6-16个字符'
					}
				],
				
				confirmPassword: [
					{
						rule: /^.{6,16}$/,
						msg: '确认密码格式不正确，长度为6-16个字符'
					}
				]
			}
		};
	},
	methods: {
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
		
		
		//验证码倒计时
			getCode(){
				if(this.codeTime>0){
					return;
				}
				this.codeTime=60
				let timer =setInterval(()=>{
					if(this.codeTime>=1){
						this.codeTime--
					}else{
						this.codeTime=0
						clearInterval(timer)
					}
				},1000)
			},
			//表单验证
			validata(){
				//手机号正则
				var mPattern = /^1[34578]\d{9}$/; 
				//输出 true
				console.log((mPattern.test(this.phone)));
			},
		submit(){
			//表单验证
			//验证用户名
			if (!this.validate('account')){
				return false;
			};
			//验证密码
			if (!this.validate('password')){
				return false;
			};
			if (!this.validate('confirmPassword')){
				return false;
			};
			
			if(this.password != this.confirmPassword){
				uni.showToast({ title: '两次密码不一致', icon: 'none'});
				return false;
			}
			
			uni.showLoading();
			
			uni.request({
				url: 'http://livechb3.changhuoban.com/api/V1/forgetPwd',
				method: 'POST',
				data: {
					code: this.code,
					account: this.account,
					password: this.password,
					password1: this.confirmPassword
				},
				success: res => {
					console.log(res)
					uni.hideToast();
					try {
						if (res.data.success) {
							uni.showToast({ title: '重置成功', icon: 'none' });
							uni.navigateTo({ url: '/pages/index/index', animationType: 'pop-in', animationDuration: 200});
							
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
	},

};
</script>

<style>
@import 'style/forgetPassword.css';
</style>
