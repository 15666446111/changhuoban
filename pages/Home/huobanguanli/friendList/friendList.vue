<template>
	<view>
		<view class="titlebars">
			<!-- 头部内容栏 -->
			<view class="titlebar">
				<view class="rise">
					<view class="rise-head">
						<image :src="UserInfo.heading" class="head" />
						<view class="name">{{ UserInfo.nickname }}</view>
						<!-- <view class="shiming">
							<image class="shiming-image" src="../../../../static/xz1.png" />
							<view class="shiming-text">已实名</view>
						</view> -->
						<view class="id">
							<view class="zhanghao">账号:{{ UserInfo.account }}</view>
						</view>
						
						<view class="" v-if="type === 1">
							<view class="zhanghao">级别:{{ UserInfo.group }}</view>
						</view>
					</view>
				</view>
			</view>
			<view class="hengxian"></view>
		</view>
		
		<view class="backgroundColor">
			<view class="data">
				<view class="phone">手机号</view>
				<view class="mark">{{ UserInfo.phone }}</view>
			</view>
			<view class="dara-xian"></view>
			<view class="data">
				<view class="phone">注册时间</view>
				<view class="mark">{{ UserInfo.created_at }}</view>
			</view>
			<view class="dara-xian"></view>
			<view class="data">
				<view class="phone">状态</view>
				<view class="mark">{{ UserInfo.active == '1' ? '正常' : '冻结' }}</view>
			</view>
		</view>
		<navigator :url="'../tradeInfo/tradeList?uid='+UserInfo.id">
			<view class="backgroundColor">
				<view class="data">
					<view class="phone">数据明细</view>
					<view class="mark">查看</view>
				</view>
			</view>
		</navigator>
		<view class="backgroundColor" v-if="type === 2">
			<view class="data">
				<view class="phone">设置政策信息</view>
			</view>
			<view class="dara-xian"></view>
			<navigator v-for="(item, index) in PolicyList" :key="index" :url="'../policy_details/share_profit?gid=' + item.id + '&uid=' + UserInfo.id">
				<view class="data">
					<view class="phone">{{item.title}}</view>
					<view class="mark">设置</view>
				</view>
			</navigator>
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
			UserInfo: {},
			PolicyList: [],
			type: ''
		};
	},
	
	onLoad: function (options){
		this.type 	= uni.getStorageSync('type');
		
		this.loadModal.show = true;
		// 获取伙伴信息
		this.getUserInfo(options.user);
		// 获取政策信息
		this.getPolicyList(options.user);
	},
	
	methods: {
	  	getUserInfo(user){
	    	net({
	        	url:"/V1/mine",
	            method:'get',
				data:{
					team_user: user,
				},
	            success: (res) => {
					this.loadModal.show = false;
					this.UserInfo = res.data.success.data;
	            },
				fail: () => { console.log("22") },
				complete: () => { console.log("33") }
	      	})
		},
		
		getPolicyList(userId){
			net({
				url:"/V1/userPolicyGroup",
				method:'GET',
				data: { uid: userId },
				success: (res) => {
					console.log(res);
					this.loadModal.show = false;
					
					if (res.data.success) {
						this.PolicyList = res.data.success.data;
					} else {
						uni.showToast({
							title: res.data.error.message,
							icon: 'none',
							position: 'bottom'
						})
					}
					
	            },
				fail: () => { console.log("22") },
				complete: () => { console.log("33") }
	      	})
		}
	}
};
</script>

<style>
@import '../../style/team_detail.css';
</style>
