<template>
	<view>
		<ms-dropdown-menu class="menu" @on-click="getInfo">
			<ms-dropdown-item v-model="value1" :list="list1"></ms-dropdown-item>
			<ms-dropdown-item v-model="value2" :list="list"></ms-dropdown-item>
		</ms-dropdown-menu>		
		<view class="detail">
			<view class="detail-view" v-for="(item, index) in tradeData" :key="index">
				<view class="datail-name">{{ item.card_type }}/{{ item.card_number }}</view>
				<view class="datail-way">
					<view class="datail-text">{{ item.trade_type }}</view>
					<view class="datail-text1">{{ item.money / 100 }}</view>
				</view>
				<view class="datail-time">
					<view class="datail-text">时间：{{ item.trade_time }}</view>
					<!-- <view class="datail-text2">交易成功</view> -->
				</view>
			</view>
			<view class="hengxian"></view>
		</view>
	</view>
</template>

<script>
	import msDropdownMenu from '@/components/ms-dropdown/dropdown-menu.vue'
	import msDropdownItem from '@/components/ms-dropdown/dropdown-item.vue'
	
	import net from '../../../../common/net.js';
	export default {
		components: {
			msDropdownMenu,
			msDropdownItem
		},
		data() {
			return {
				list: [
					{
						text: '全部',
						value: 0
					},
					{
						text: '当日',
						value: 1
					},
					{
						text: '当月',
						value: 2
					}
				],
				list1: [
					{
						text: '全部',
						value: 0
					}
				],
				value1: 0,
				
				value2: 1,
				
				value3: 'init',
				
				merchant_sn: "",
				// 交易数据
				tradeData: {}
			}
		},
		// watch: {
		// },
		onLoad(options) {
			uni.showLoading();
			this.merchant_sn = options.merchant_sn;
			// 获取交易数据
			this.getTradeList(options.merchant_sn);
		},
		watch:{
			value2(val){
				if(val == 0){
					uni.showLoading();
					this.getTradeList(this.merchant_sn, 'count');
				}
				
				if(val == 1){
					uni.showLoading();
					this.getTradeList(this.merchant_sn, 'day');
				}
				
				if(val == 2){
					uni.showLoading();
					this.getTradeList(this.merchant_sn, 'month');
				}
			}
		},
		methods: {
			
			choose() {
				let obj = {}
				this.$refs.dropdownItem.choose(obj);
			},
			
            close() {
                this.$refs.dropdownItem.closePopup();
            },
			
			// 获取交易列表
			getTradeList(termNo, data_type){
				net({
					url: '/V1/getMerchantDetails',
					method: 'GET',
					data: {
						merchant: termNo,
						data_type: data_type
					},
					success: (res) => {
						uni.hideLoading();
						if (res.data.success) {
							this.tradeData = res.data.success.data;
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
	}
</script>

<style lang="scss">
@import url('../../style/merchant_trade.css');
</style>
