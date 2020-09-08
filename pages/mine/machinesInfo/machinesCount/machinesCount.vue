<template>
	<view>
		<view id="view">
			<view id="view_view">
				<image src="../../../../static/sousuo.png"></image>
				<input placeholder="  请输入有效的SN号" class="v_input" placeholder-class="place" />
			</view>
		</view>
		<view id="body">
			<view id="view2">
				<view 
					v-for="(item, index) in typeList"
					:key="index" 
					class="views" 
					:id="tabIndex == index ? 'v1' : ''"
					@click="changTab(index)"
					>
					{{item.name}}
				</view>
			</view>
			<view id="view3" v-if="list.length != 0">
				<view class="view_sn" v-for="(item, index) in list" :key="index">
					<view class="bk">
						<view class="line">
							<view class="p1">SN: {{item.merchant_sn}}</view>
							<view class="p2">{{item.bind_status == 0 ? '未绑定' : '已绑定'}}/{{item.active_status == 0 ? '未激活' : '已激活'}}</view>
						</view>
						
						<view class="line">
							<view class="p3"> 活动：{{item.title}}</view>
							<view class="p4">绑定时间：{{item.bind_time}}</view>						
						</view>
					</view>
				</view>
			</view>
			
			<view v-if="list.length == 0" style="color:#999; padding-top: 200rpx; text-align: center;">
				暂无数据～
			</view>
		</view>
		
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
				{'name': '全部', 'value': 0},
				{'name': '已绑定', 'value': 1},
				{'name': '未绑定', 'value': 2},
				{'name': '已激活', 'value': 3},
			],
			tabIndex: '',
			list: {},
			merchantList: {},
			
		};
	},
	
	onLoad(options) {
		this.loadModal.show = true;
		// 获取机具列表
		this.getMerchantList(options.type);
	},
	
	methods: {
		changTab(index){
			if (this.tabIndex == index) return;
			this.tabIndex = index;
			if (index == 0) {
				this.list = this.merchantList.AllMerchants;
			}
			if (index == 1) {
				this.list = this.merchantList.Bound;
			}
			if (index == 2) {
				this.list = this.merchantList.UnBound;
			}
			if (index == 3) {
				this.list = this.merchantList.Bind;
			}
		},
		
		// 获取机具列表
		getMerchantList(type) {
			net({
				url: '/V1/getTail',
				method: 'GET',
				data: { Type: type },
				success: (res) => {
					this.loadModal.show = false;
					if (res.data.success) {
						this.merchantList = res.data.success.data;
						this.list = this.merchantList.AllMerchants;
					} else {
						uni.showToast({ title: res.data.error.message, icon: 'none',position: 'bottom'})
					}
				}
			})
		}
	}
};
</script>

<style>
	@import url("../../style/merchant_list.css");
</style>