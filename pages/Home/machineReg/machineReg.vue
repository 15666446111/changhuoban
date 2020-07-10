<template>
	<view id="body">
		<!-- 头部注释 -->
		<view class="fr_top">
			<image class="fr_image" src="/static/mark.png" />
			<view class="view_p">注：为保证正常使用，请妥善填写信息。</view>
		</view>

		<!-- 第一栏 -->
		<view class="selects">
			<view class="select">
			<navigator  hover-class="none"  url="machineChoice/machineChoice">
				<view class="select-view">
					<view class="select-name">终端选择</view>
					<view class="select-text1" v-if="merchant_sn == ''">请选择</view>
					<view class="select-text1">{{ merchant_sn }}</view>
					<image class="select-image" src="/static/EPOS/jiantou.png" />
				</view>
			</navigator>
			</view>
		</view>
		<!-- 第二栏 -->
		<view class="selects">

			<!-- 第三栏 -->
			<view class="select">
				<view class="select-view">
					<view class="select-name">商户姓名</view>
					<input class="select-text" placeholder="请输入商户姓名" placeholder-class="place" v-model="merchant_name" />
				</view>
				<view class="hengxian"></view>
			</view>
			
			<!-- 第三栏 -->
			<view class="select">
				<view class="select-view">
					<view class="select-name">商户电话</view>
					<input type="number" class="select-text" placeholder="请输入商户手机号" placeholder-class="place" v-model="merchant_phone" />
				</view>
			</view>
		</view>
		<button class="button1" @click="submit()">确 认 登 记</button>
		<!-- <navigator  hover-class="none"  url="shanghuxinxi/shanghuxinxi"><button class="button2">A 类 商 户 入 网</button></navigator> -->
	</view>
</template>

<script>
import net from '../../../common/net.js';
export default {
	data() {
		return {
			merchant_sn: '',
			merchant_name: '',
			merchant_phone: '',
			//验证规则
			rules: {
				merchant_phone: [
					{
						rule: /^1[3456789]\d{9}$/,
						msg: '手机号格式不正确'
					}
				]
			},
			'operate': ''
		};
	},
	
	onLoad(option) {
		this.operate 	= uni.getStorageSync('operate');
		this.merchant_sn = (option.merchant_sn == undefined ? '' : option.merchant_sn);
	},
	
	methods: {
		//表单验证
		validate(key) {
			var check = true;
			this.rules[key].forEach(v => {
				//验证失败
				if (!v.rule.test(this[key])) {
					uni.showToast({ title: v.msg, icon: 'none', position: 'bottom' });
					check = false;
					return false;
				}
			});
			return check;
		},
		// 提交表单
		submit(){
			if (this.merchant_sn == '') {
				uni.showToast({ title: '请选择登记的终端', icon: 'none' });
				return false;
			}
			
			if (this.merchant_name == '') {
				uni.showToast({ title: '请填写商户名称', icon: 'none' });
				return false;
			}
			// 商户手机号验证
			if (!this.validate('merchant_phone')) {
				return false;
			}
			
			uni.showLoading();
	
			net({
	        	url: "/V1/register",
	            method: 'GET',
				data: {
					merchant_name: this.merchant_name,
					merchant_phone: this.merchant_phone,
					merchant_sn: this.merchant_sn,
					operate:this.operate
				},
	            success: (res) => {
					uni.hideLoading();
					
					if (res.data.success) {
						uni.showToast({ title: '登记成功', icon: 'none',
							success : function(){
								setTimeout(function() { uni.navigateBack(); }, 1500);
							}
						});
					} else {
						uni.showToast({ title: res.data.error.message, icon: 'none' });
					}
	            }
	      	})
		}
	}
};
</script>

<style>
@import url("../style/merchant_check_in.css");
</style>
