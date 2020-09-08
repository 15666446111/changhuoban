<template>
		<view class="teams">
			<!-- 直营业绩 -->
			<view class="team" v-if="type == 'self'">
				<view class="the">直营业绩</view>
				<view class="across"></view>
				
				<view class="view" >
					<view class="jiaoyi" v-for="(item, index) in selfList" :key="index" >
						<view class="jiaoyi-text">{{ item.title }}</view>
						<view class="jiuaoyi-shuzi">{{ item.money }}</view>
					</view>
				</view>
					
				<view v-if="selfList == '' || selfList == undefined">
					<view class="null-tips">—— 暂无数据 ——</view>
				</view>
			</view>
			<view class="team">
				<view class="the">代理业绩</view>
				<view class="across"></view>
				
				<view class="view" >
					<view class="jiaoyi" v-for="(item, index) in agentList" :key="index" >
						<view class="jiaoyi-text">{{ item.title }}</view>
						<view class="jiuaoyi-shuzi">{{ item.money }}</view>
					</view>
					
					<view v-if="agentList == '' || agentList == undefined">
						<view class="null-tips">—— 暂无数据 ——</view>
					</view>
				</view>
			</view>
		</view>
</template>

<script>
import net from '../../../common/net.js';

export default {
	data() {
		return {
			userInfo: {},
			type: '',		// 类型 self/other
			dateType: '',	// 日期类型 day/month
			agentId: 0,		// 需要查询的代理id
			date: '',		// 查询的日期
			
			selfList: {},	// 直营数据
			agentList: {},	// 代理数据
			
		}
	},
	
	onLoad(options) {
		uni.showLoading();
		this.agentId = options.uid;
		this.dateType = options.date_type;
		this.type = options.type;
		this.date = options.date;
		
		// 获取交易数据
		this.getTradeData();
	},
	
	methods: {
		// 获取交易数据
		getTradeData(){
			net({
	        	url:"/V1/getTeamTradeDetail",
	            method:'get',
				data: {
					type: this.type,
					agent_id: this.agentId,
					dateType: this.dateType,
					date: this.date,
				},
	            success: (res) => {
					uni.hideLoading();
					if (res.data.success) {
						this.selfList = res.data.success.data.self;
						this.agentList = res.data.success.data.agent;
					} else {
						uni.showToast({
							title: res.data.error.message,
							icon: 'none',
							position: 'bottom'
						})
					}
	            }
	      	})
		}
	}
}
</script>

<style>
	@import url("../style/total_list.css");
</style>
