<template>
	<view>
		<!-- 输入框 -->
		<view class="indexs">
			
			<view class="cu-form-group">
				<view class="title">姓名</view>
				<input placeholder="请输入您的姓名" v-model="BankInfo.user_name" ></input>
			</view>
			<view class="cu-form-group">
				<view class="title">身份证号</view>
				<input placeholder="请输入您的身份证号" v-model="BankInfo.number" ></input>
			</view>
			<view class="cu-form-group">
				<view class="title">银行</view>
				<input placeholder="请输入银行名称" v-model="BankInfo.bank_name" ></input>
			</view>
			<view class="cu-form-group">
				<view class="title">银行卡号</view>
				<input placeholder="请输入银行卡号" v-model="BankInfo.bank" ></input>
			</view>
			<view class="cu-form-group">
				<view class="title">开户行</view>
				<input placeholder="请输入开户行" v-model="BankInfo.open_bank" ></input>
			</view>
			<view class="cu-form-group">
				<view class="title">省</view>
				<input placeholder="请输入省" v-model="BankInfo.province" ></input>
			</view>
			<view class="cu-form-group">
				<view class="title">市</view>
				<input placeholder="请输入市" v-model="BankInfo.city" ></input>
			</view>
			<view class="select-view"> 
				<checkbox-group @change="defaultType">
					<label>
						<checkbox class="se-defulat" value="1" color="#FF8C00" :checked="this.BankInfo.is_default == 1 ? true : false" />设为默认
					</label>
				</checkbox-group>
			</view>
		</view>
		<button @click="submit">确 定</button>
		
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
			id: '',
			
			BankInfo: []
		};
	},
	
	onLoad(option) {
		this.id = option.card_id;
		
		this.loadModal.show = true;
		// 获取银行卡信息
		this.getBankInfo();
	},
	
	methods: {
		// 获取银行卡信息
		getBankInfo(){
			net({
	        	url: "/V1/getBankFirst",
	            method: 'GET',
				data: {
					id: this.id,
				},
	            success: (res) => {
					this.loadModal.show = false;
					if (res.data.success) {
						this.BankInfo = res.data.success.data;
						console.log(this.BankInfo);
					} else {
						uni.showToast({
							title: res.data.error.message,
							icon: 'none'
						});
					}
	            }
	      	})
		},
		
		defaultType(e){
			this.BankInfo.is_default = (e.detail.value == 1 ? 1 : 0);
		},
		
		submit(){
			// console.log(this.BankInfo.is_default);return
			if (this.user_name == '') {
				uni.showToast({ title: '姓名不能为空', icon: 'none' });
				return false;
			}
			
			if (this.number == '') {
				uni.showToast({ title: '身份证号不能为空', icon: 'none' });
				return false;
			}
			
			if (this.bank_name == '') {
				uni.showToast({ title: '银行名称不能为空', icon: 'none' });
				return false;
			}
			
			if (this.bank == '') {
				uni.showToast({ title: '银行卡号不能为空', icon: 'none' });
				return false;
			}
			
			if (this.open_bank == '') {
				uni.showToast({ title: '开户行不能为空', icon: 'none' });
				return false;
			}
			
			if (this.province == '') {
				uni.showToast({ title: '省不能为空', icon: 'none' });
				return false;
			}
			
			if (this.city == '') {
				uni.showToast({ title: '市不能为空', icon: 'none' });
				return false;
			}
			
			this.loadModal.show = true;
			
			net({
	        	url: "/V1/upBank",
	            method: 'GET',
				data: {
					id: this.id,
					name: this.BankInfo.user_name,
					number: this.BankInfo.number,
					bank_name: this.BankInfo.bank_name,
					bank: this.BankInfo.bank,
					open_bank: this.BankInfo.open_bank,
					is_default: this.BankInfo.is_default,
					province: this.BankInfo.province,
					city: this.BankInfo.city,
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
};
</script>

<style>
	@import url("../../style/settle_card.css");
	.cu-form-group .title {
		min-width: calc(4em + 15px);
	}
</style>
