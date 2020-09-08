<template>
	<view class="background">
		<view v-for="(item, index) in cardList" :key="index" class="bank-list">
			<view class="top" @click="optCard(item)">
				<!-- <image src="" class="img"></image> -->
				<view class="fview">
					<view class="ms">{{ item.bank_name }}</view>
					<view class="cxk">储蓄卡</view>
				</view>
				<view class="kahao">{{ item.bank }}</view>
			</view>
			<view class="top2">
				<view class="mbc">
					<checkbox class="radio" checked="true" disabled="false" v-if="item.is_default == 1">默认结算卡</checkbox>
					<view class="bank-edit" @click="cardEdit(item.id)">
						<uni-icons type="compose" size="20" class="edit-icon" color="#EE4000"></uni-icons> 修改
					</view>
					<view class="bank-edit" @click="cardDel(item.id, index)">
						<uni-icons type="trash" size="20" class="edit-icon" color="#EE4000"></uni-icons> 删除
					</view>
				</view>
			</view>
		</view>
		
		<navigator  hover-class="none"  url="../../bankSet/bankCreate/bankCreate">
			<button class="bck">添加银行卡</button>
		</navigator>
		
		<view class="cu-load load-modal" v-if="loadModal.show">
		   <image src="/static/public/loading.png" mode="aspectFit"></image>
		   <view class="gray-text">{{ loadModal.text }}</view>
		</view>
	</view>
</template>

<script>
	import net from '../../../../common/net.js';
		
	import uniIcons from '@/components/uni-icons/uni-icons.vue'
	export default {
		components: {
			uniIcons
		},
		data() {
			return {
				loadModal: {
					show: false,
					text: '加载中...'
				},
				// 银行卡列表
				cardList: [],
				getIntoPage: '',
				// show: '',
			};
		},
		
		onLoad(options) {
			this.getIntoPage = options.pages != '' ? options.pages : '';
		},
		
		onShow() {
			this.loadModal.show = true;
			// 获取银行卡列表
			this.getBankList();
		},
		
		methods: {
			// 获取银行卡列表
			getBankList(){
				net({
		        	url:"/V1/getBankInfo",
		            method:'get',
		            success: (res) => {
						this.loadModal.show = false;
						if (res.data.success) {
							this.cardList = res.data.success.data;
						} else {
							uni.showToast({
								title: res.data.error.message,
								icon: 'none',
								success : function(){
									setTimeout(function() {
										uni.navigateBack();
									}, 1500);
								}
							});
						}
		            }
		      	})
			},
			
			// 修改卡信息
			cardEdit(bankId){
				uni.navigateTo({
					url: '../../bankSet/bankCreate/settle_card_edit?card_id=' + bankId
				})
			},
			
			// 删除卡信息
			cardDel(bankId, listKey){
				uni.showModal({
					title: '提示',
					content: '确定要删除当前结算卡信息吗？',
					success: (res) => {
						if (res.confirm) {
							// 加载动画
							this.loadModal.show = true;
							
							net({
					        	url:"/V1/deBank",
					            method:'get',
								data: {
									'id' : bankId
								},
					            success: (res) => {
									this.loadModal.show = false;
									
									if (res.data.success) {
										uni.showToast({ title: '删除成功', icon: 'none' });
										let _this = this;
										setTimeout(function() {
											uni.redirectTo({
												url: './bankList?pages=' + _this.getIntoPage
											})
										}, 1000);
									} else {
										uni.showToast({ title: res.data.error.message, icon: 'none' });
									}
					            }
					      	})
						}
					}
				})
			},
			
			// 选择银行卡信息跳转
			optCard(item){
				if (this.getIntoPage) {
					var pages = getCurrentPages();
					var prevPage = pages[pages.length - 2]; //上一个页面
					
					var data = {
						id : item.id,
						bank_name : item.bank_name,
						bank : item.bank,
					};
					prevPage.$vm.bankCard = data;
					uni.navigateBack();
				}
			}
		}
	};
</script>

<style>
@import url("../../style/user_bank_card");
</style>
