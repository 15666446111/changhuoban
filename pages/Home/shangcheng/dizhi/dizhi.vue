<template>
	<view class="ID">
		<!-- 按钮 -->
		<navigator  hover-class="none"  url="../xinzeng/xinzeng" open-type="navigate">
			<view id="button">
				<image class="button-img" src="../../../../static/+.png" mode="widthFix"></image>
				<view class="button-text">添加新的发货地址</view>
			</view>
		</navigator>

		<view class="site" v-for="(item, index) in addressList" :key="index">
			<view @click="optAddress(item)">
				<view class="site-view">
					<view class="site-name">{{ item.name }}</view>
					<view class="site-phone">{{item.tel}}</view>
				</view>
				<view class="site-text"><view class="site-name">{{item.province}}{{item.city}}{{item.area}}{{item.detail}}</view></view>
				<view class="site-xian"></view>
			</view>
			<!-- 默认框 -->
			<view class="group">
				<view class="ckeck">
					<checkbox :checked="item.is_default == 1 ? true : false" disabled="true" color="#ED6E11"><text class="moren">默认</text></checkbox>
				</view>
				<!-- 编辑删除 -->
				<view class="site-for">
					<view class="for" @click="addressDel(item.id, index)">
						<image class="for-img" src="../../../../static/shanchu.png" mode="widthFix"></image>
						<view class="for-text">删除</view>
					</view>
					<navigator  hover-class="none"  :url="'../xinzeng/address_edit?address_id=' + item.id">
						<view class="for">
								<image class="for-img" src="../../../../static/xiugai.png" mode="widthFix"></image>
								<view class="for-text">编辑</view>
						</view>
					</navigator>
				</view>
			</view>
		</view>
	</view>
</template>

<script>
import net from '../../../../common/net.js';
export default {
	data() {
		return {
			addressList: {},
			getIntoPage: '',
		};
	},
	
	onLoad(options) {
		this.getIntoPage = options.pages != '' ? options.pages : '';
	},
	
	onShow() {
		// 获取收货地址
		this.getAddress();
	},
	
	methods: {
		// 获取收货地址
		getAddress(){
			net({
				url: '/V1/getAddress',
				method: 'GET',
				success: (res) => {
					if (res.data.success) {
						this.addressList = res.data.success.data;
					} else {
						uni.showToast({
							title: res.data.error.message,
							icon: 'none'
						})
					}
				}
			})
		},
		
		// 收货地址删除
		addressDel(aid, key){
			uni.showModal({
				content: '确定要删除当前地址信息吗？',
				success: (res) => {
					if (res.confirm) {
						// 显示加载动画
						uni.showLoading();
						
						net({
							url: '/V1/deAddress',
							method: 'GET',
							data: { 'id': aid },
							success: (res) => {
								// 关闭加载动画
								uni.hideLoading();
								
								if (res.data.success) {
									uni.showToast({ title: '删除成功', icon: 'none' })
									let _this = this;
									setTimeout(function() {
										uni.redirectTo({
											url: './dizhi?pages=' + _this.getIntoPage
										})
									}, 1000);
								} else {
									uni.showToast({
										title: res.data.error.message,
										icon: 'none'
									})
								}
							}
						})
					}
				}
			})
		},
		
		// 选择银行卡跳转
		optAddress(item){
			if (this.getIntoPage) {
				var pages = getCurrentPages();
				var prevPage = pages[pages.length - 2]; //上一个页面
				
				var data = {
					id : item.id,
					name : item.name,
					tel : item.tel,
					province : item.province,
					area : item.area,
					detail : item.detail
				};
				prevPage.$vm.address = data;
				uni.navigateBack();
			}
		}
	}
};
</script>

<style>
@import url("../../style/address.css");
</style>
