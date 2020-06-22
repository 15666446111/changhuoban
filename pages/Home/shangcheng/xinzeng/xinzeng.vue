<template>
	<view class="ID">
		<view class="indexs">
			<view class="select">
				<view class="select-view">
					<view class="select-name">收货人：</view>
					<input class="select-text" placeholder="请填写姓名" v-model="name" />
				</view>
				<view class="hengxian"></view>
				<view class="select-view">
					<view class="select-name">联系电话：</view>
					<input class="select-text" placeholder="请填写手机号码" v-model="tel" />
				</view>
				<view class="hengxian"></view>
				<view class="select-view1">
					<view class="select-name">所在地区：</view>
					<view class="tab select-text1" @tap="toggleTab('region')">{{ resultInfo.result }}</view>
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
				<view class="hengxian"></view>
				<view class="select-view">
					<view class="select-name">详细地址：</view>
					<input class="select-text" placeholder="请填写详细地址" v-model="detail"/>
				</view>
			</view>
		</view>
		<view class="ckeck">
			<checkbox-group @change="defaultCheck">
				<checkbox checked="true" value="1" color="#ED6E11"><text class="moren">默认</text></checkbox>
			</checkbox-group>
		</view>

		<view><button @click="addressAdd">保 存</button></view>
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
			title: 'Hello',
			startYear: new Date().getFullYear(),
			regionDval: ['北京市', '市辖区', '东城区'],
			resultInfo: {
				result: '请选择所在地区'
			},
			
			name: '',
			tel: '',
			detail: '',
			is_default: 1,
		};
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
		
		// 添加地址
		addressAdd(){
			var telVer = /^1[356789]\d{9}$/;
			
			if (this.name == '') {
				uni.showToast({ title: '请填写收货人姓名', icon: 'none'});
				return false;
			}
			if (!telVer.test(this.tel)) {
				uni.showToast({ title: '手机号格式不正确', icon: 'none'});
				return false;
			}
			if (this.resultInfo.checkArr == undefined) {
				uni.showToast({ title: '请选择所在地区', icon: 'none'});
				return false;
			}
			if (this.detail == '') {
				uni.showToast({ title: '请填写详细地址', icon: 'none'});
				return false;
			}
			
			uni.showLoading();
			
			net({
				url: '/V1/addressAdd',
				method: 'POST',
				data: {
					'name' : this.name,
					'tel' : this.tel,
					'province' : this.resultInfo.checkArr[0],
					'city' : this.resultInfo.checkArr[1],
					'area' : this.resultInfo.checkArr[2],
					'detail' : this.detail,
					'is_default' : this.is_default,
				},
				success: (res) => {
					uni.hideLoading();
					try{
						if (res.data.success) {
							uni.showToast({
								title: '添加成功',
								icon: 'none',
								success() {
									setTimeout(function() {
										uni.redirectTo({
											url: 'xinzeng'
										})
									}, 1500);
								}
							})
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
</style>

