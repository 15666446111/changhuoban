<template>
	<view class="ID">
		<view class="indexs">
			
			<view class="cu-form-group">
				<view class="title">收货人</view>
				<input placeholder="请填写姓名" v-model="addressInfo.name" ></input>
			</view>
			<view class="cu-form-group">
				<view class="title">联系电话</view>
				<input placeholder="请填写手机号码" v-model="addressInfo.tel" ></input>
			</view>
			<view class="cu-form-group">
				<view class="title">所在地区</view>
				<view class="w-picker picker" @tap="toggleTab('region')">{{ resultInfo.result }}</view>
				<w-picker
					mode="region"
					:defaultVal="regionDval"
					:areaCode="['11', '1101', '110101']"
					:hideArea="false"
					@confirm="onConfirm"
					ref="region"
					:timeout="true"
				></w-picker>
			</view>
			<view class="cu-form-group">
				<view class="title">详细地址</view>
				<input placeholder="请填写详细地址" v-model="addressInfo.detail" ></input>
			</view>
			
			<view class="cu-form-group">
				<checkbox-group @change="defaultCheck">
				<checkbox :checked="is_default == 1 ? true : false" value="1" color="#ED6E11"></checkbox>
					<text class="moren">默认</text>	
				</checkbox-group>
			</view>
		</view>

		<view><button @click="addressEdit">保 存</button></view>
		
		<view class="cu-load load-modal" v-if="loadModal.show">
		   <image src="/static/public/loading.png" mode="aspectFit"></image>
		   <view class="gray-text">{{ loadModal.text }}</view>
		</view>
	</view>
</template>

<script>
import wPicker from '@/components/w-picker/w-picker.vue';

import net from '../../../../common/net.js';

export default {
	components: {
		wPicker
	},
	data() {
		return {
			loadModal: {
				show: false,
				text: '提交中...'
			},
			
			title: 'Hello',
			startYear: new Date().getFullYear(),
			regionDval: ['北京市', '市辖区', '东城区'],
			resultInfo: {
				result: '请选择所在地区'
			},
			
			addressInfo: {},
			is_default: ''
		};
	},
	
	onLoad(options) {
		var addressId = options.address_id;
		
		this.loadModal.show = true;
		// 获取需要修改的收货地址信息
		this.getAddressInfo(addressId);
	},
	
	methods: {
		toggleTab(str) {
			this.$refs[str].show();
		},
		onConfirm(val) {
			this.resultInfo = { ...val };
			console.log(this.resultInfo);
		},
		
		// 默认收货地址选择
		defaultCheck(e){
			this.is_default = e.detail.value == 1 ? 1 : 0;
		},
		
		// 获取需要修改的收货地址信息
		getAddressInfo(addressId){
			net({
				url: '/V1/getFirstAddress',
				method: 'GET',
				data: {
					'id' : addressId
				},
				success: (res) => {
					this.loadModal.show = false;
					if (res.data.success) {
						// 收货地址信息
						this.addressInfo = res.data.success.data;
						
						// 省市区
						var province = this.addressInfo.province,
							city = this.addressInfo.city,
							area = this.addressInfo.area;
							
						this.resultInfo.result = province + city + area;
						this.resultInfo.checkArr = [province, city, area];
						// 默认状态
						this.is_default = this.addressInfo.is_default;
					} else {
						uni.showToast({
							title: res.data.error.message,
							icon: 'none'
						})
					}
				}
			})
		},
		
		// 修改地址
		addressEdit(){
			var telVer = /^1[356789]\d{9}$/;
			
			if (this.addressInfo.name == '') {
				uni.showToast({ title: '请填写收货人姓名', icon: 'none'});
				return false;
			}
			if (!telVer.test(this.addressInfo.tel)) {
				uni.showToast({ title: '手机号格式不正确', icon: 'none'});
				return false;
			}
			if (this.resultInfo.checkArr == undefined) {
				uni.showToast({ title: '请选择所在地区', icon: 'none'});
				return false;
			}
			if (this.addressInfo.detail == '') {
				uni.showToast({ title: '请填写详细地址', icon: 'none'});
				return false;
			}
			
			this.loadModal.show = true;
			
			net({
				url: '/V1/upAddress',
				method: 'GET',
				data: {
					'id' : this.addressInfo.id,
					'name' : this.addressInfo.name,
					'tel' : this.addressInfo.tel,
					'province' : this.resultInfo.checkArr[0],
					'city' : this.resultInfo.checkArr[1],
					'area' : this.resultInfo.checkArr[2],
					'detail' : this.addressInfo.detail,
					'is_default' : this.is_default,
				},
				success: (res) => {
					this.loadModal.show = false;
					console.log(res);
					try{
						if (res.data.success) {
							uni.showToast({ title: '修改成功', icon: 'none' });
							setTimeout(function() {
								uni.navigateBack();
							}, 1000);
						} else {
							uni.showToast({
								title: res.data.error.message,
								icon: 'none'
							})
						}
					} catch (e) {
						uni.showToast({
							title: '系统错误，请联系客服',
							icon: 'none'
						})
					}
					
				}
			})
		}
	}
};
</script>

<style>
	@import url("../../style/address_add.css");
	.cu-form-group .title {
		min-width: calc(4em + 15px);
	}
</style>

