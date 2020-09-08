<template>
		<view class="teams">
			
			<view class="team" v-if="data.self != undefined">
				<view class="the">直营业绩</view>
				<view class="across"></view>
				<view class="view" >
					<view class="jiaoyi" v-for="(item, index) in data.self" :key="index">
						<view class="jiaoyi-text">{{ item.title }}</view>
						<view class="jiuaoyi-shuzi">{{ item.count }}</view>
					</view>
				</view>
			</view>
			
			<view class="team" v-if="data.agent != undefined">
				<view class="the">代理业绩</view>
				<view class="across"></view>
				<view class="view" >
					<view class="jiaoyi" v-for="(item, index) in data.agent" :key="index">
						<view class="jiaoyi-text">{{ item.title }}</view>
						<view class="jiuaoyi-shuzi">{{ item.count }}</view>
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
				type: '',		// 类型 self/other
				dateType: '',	// 日期类型 day/month
				agentId: 0,		// 需要查询的代理id
				date: '',		// 查询的日期
				
				data: {},
			}
		},
		
		onLoad(options){
			uni.showLoading();
			this.agentId = options.uid;
			this.dateType = options.date_type;
			this.type = options.type;
			this.date = options.date;
			
			// 获取某个代理的今天商户数据分析
			this.getAgentTeam(options.uid);
		},
	
		methods: {
			getAgentTeam(uid){
		    	net({
		        	url:"/V1/getAgentTeam",
		            method:'get',
					data: {
						type: this.type,
						agent_id: this.agentId,
						dateType: this.dateType,
						date: this.date,
					},
		            success: (res) => {
						console.log(res);
						uni.hideLoading();
						if (res.data.success) {
							this.data = res.data.success.data;
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