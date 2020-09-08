<template>
	<view>
		<!-- 选择框 -->
		<view class="select">
			<view class="hengxian"></view>
			<view class="select-div1">
				<view class="div-text" v-for="(item, index) in typeList" :key="index"
					 :class="currentType == item.type ? 'checked-type' : ''"
					 @click="switchType(item.type, item.name)"
						>
					{{ item.title }}
				</view>
			</view>
		</view>
		<!--  -->
		<view class="content">
			<view class="content-view">
				<view v-for="(item, index) in merchantList" :key='index'>
					<view class="content-div">
						<view class="div">
							<view class="content-text">调拨用户:{{item.friend_name}}</view>
							<view class="content-text1" v-if="currentType == 'my_transfer' || currentType == 'parent_transfer'">类型：划拨</view>
							<view class="content-text1" v-if="currentType == 'my_back' || currentType == 'parent_back'">类型：回拨</view>
						</view>
						<view class="div">
							<view class="name">SN: {{item.merchant_sn }}</view>
							<view class="time">{{ item.created_at }}</view>
						</view>
					</view>
					<view class="hengxian1"></view>
				</view>
			</view>
		</view>
		
		<view v-if="merchantList == '' || merchantList == undefined" class="null-tips">—— 没有调拨记录 ——</view>
		
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
				text: '加载中...'
			},
			typeList: [
				{ title: '我的划拨', type: 'my_transfer' },
				{ title: '我的回拨', type: 'my_back'},
				{ title: '上级划拨', type: 'parent_transfer'},
				{ title: '上级回拨', type: 'parent_back'}
			],
			currentType: 'my_transfer',
			merchantList: {}
		};
	},
	
	onLoad() {
		this.loadModal.show = true;
		// 获取划拨回拨记录
		this.getTransferLog();
	},
	
	methods: {
		// 获取划拨回拨记录
		getTransferLog(){
			net({
				url: '/V1/getTransferLog',
				method: 'GET',
				data: {
					type: this.currentType
				},
				success: (res) => {
					console.log(res);
					this.loadModal.show = false;
					if (res.data.success) {
						this.merchantList = res.data.success.data;
					} else {
						uni.showToast({
							title: res.data.error.message,
							icon: 'none'
						})
					}
				}
			})
		},
		
		switchType(type, title){
			if (this.currentType == type) {
				return false;
			}
			this.loadModal.show = true;
			
			this.currentType = type;
			this.getTransferLog();
		}
	}
};
</script>

<style>
@import url("../../style/transfer_log.css");
</style>
