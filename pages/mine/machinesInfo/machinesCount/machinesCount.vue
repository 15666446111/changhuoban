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
					@click="changTab(index)">
					{{item.name}}
				</view>
			</view>
			<view id="view3">
				<view class="view_sn" v-for="(item, index) in list" :key="index">
					<view class="p1">SN:{{item.merchant_sn}}</view>
					<view class="p2">{{item.bind_status == 0 ? '未绑定' : '已绑定'}}/{{item.active_status == 0 ? '未激活' : '已激活'}}</view>
					<view class="p3">
						活动：
						<view class="p3_1"></view>
						{{item.title}}
					</view>
					<view class="p4">绑定时间：{{item.bind_time}}</view>
					<view class="divLine"></view>
					
					<view class="xian"></view>
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
					console.log(res);
					if (res.data.success) {
						this.merchantList = res.data.success.data;
						this.list = this.merchantList.AllMerchants;
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
};
</script>

<style>
	@import url("../../style/merchant_list.css");
</style>