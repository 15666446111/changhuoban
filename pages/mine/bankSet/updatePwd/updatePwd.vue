<template>
	<view class="body">
		<view class="bview">
			<input type="password" placeholder="旧密码" class="old" v-model="oldPass"></input>
		</view>

		<view>
			<input type="password" placeholder="新密码" class="new" v-model="newPass"></input>
			<input type="password" placeholder="确认新密码" class="new2" v-model="newPassAgain"></input>
		</view>

		<button class="psy" @click="submit">确定</button>
		
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
					text: '提交中...'
				},
				
				oldPass: '',
				newPass: '',
				newPassAgain: '',
				applyText: '<div>345</div>',
				//验证规则
				rules: {
					oldPass: [
						{
							rule: /^.{6,16}$/,
							msg: '密码格式不正确，长度为6-16个字符'
						}
					],
					newPass: [
						{
							rule: /^.{6,16}$/,
							msg: '密码格式不正确，长度为6-16个字符'
						}
					],
				}
			};
		},
		methods: {
			// apply(){
			// 	this.$refs.popup.open()
			// },
			//表单验证
			validate(key) {
				var check = true;
				this.rules[key].forEach(v => {
					//验证失败
					if (!v.rule.test(this[key])) {
						uni.showToast({ title: v.msg, icon: 'none', position: 'bottom'});
						check = false;
						return false;
					}
				});
				return check;
			},
			
			//提交表单
			submit() {
				//旧密码验证
				if (!this.validate('oldPass')){
					return false;
				};
				//新密码验证
				if (!this.validate('newPass')){
					return false;
				};
				//确认密码验证
				if (this.newPassAgain != this.newPass){
					uni.showToast({
						title: '两次输入的密码不一致',
						icon: 'none',
						position: 'bottom'
					});
					return false;
				};
				
				this.loadModal.show = true;
				
				net({
		        	url:"/V1/setUserPwd",
		            method:'get',
					data: {
						password: this.oldPass,
						newPassword: this.newPass
					},
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
@import '../../style/setting.css';
</style>
