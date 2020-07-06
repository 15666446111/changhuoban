<template>
	<view>
		<view class="sousuo">
			<view class="sousuo-view">
				<image class="input-image" src="/static/left_fdj.png" mode="aspectFit"></image>
				<input class="input" placeholder="请正确伙伴手机号" />
			</view>
		</view>
		
		<view  v-if="partnerList.length != 0">
			<view class="view" v-for="(item, index) in partnerList" :key="index" v-if="item.id != userInfo.id" @click="optPartner(item)">
				<view class="checkbox-view">
					<text class="checkbox-text">{{item.nickname}}</text>
					<!-- <radio class="checkbox" :value="item.id" color="#f98021" /> -->
				</view>
				<view class="xian"></view>
				<view class="phone-time">
					<view class="phone">
						<view class="phone-name">手机号</view>
						<view class="phone-text">{{item.phone}}</view>
					</view>
					<view class="phone">
						<view class="phone-name">加入时间</view>
						<view class="phone-text">{{item.created_at}}</view>
					</view>
				</view>
				<view class="xian"></view>
				<view class="examine">
					
					<view class="shu"></view>
					<view class="examine-text">查看更多信息</view>
				</view>
			</view>
		</view>
		
		<view v-if="partnerList.length == 0" style="font-size: 32rpx; color:#999; padding-top: 200rpx; text-align: center;">
			暂无可选伙伴～
		</view>
		
		<!-- <button type="default" class="optPartner">确定</button> -->
	</view>
</template>
<script>
import net from '../../../../common/net.js';
export default {
	data() {
		return {
			partnerList: {},
			userInfo: {},
			partnerId: '',
		};
	},
	
	onLoad() {
		// 获取下级用户列表（包括自己）
		this.getTeamUser();
	},
	
	methods: {
		// 获取下级用户列表（包括自己）
		getTeamUser(){
			net({
				url: '/V1/my_team',
				method: 'GET',
				success: (res) => {
					if(res.data.success)
						this.partnerList = res.data.success.data.list;
					else
						uni.showToast({ title: res.data.error.message, icon: 'none' });
				}
			})
		},
		
		// 获取个人信息
	  	getUserInfo(){
	    	net({
	        	url:"/V1/mine",
	            method:'get',
	            success: (res) => {
					this.userInfo = res.data.success.data;
	            }
	      	})
		},
		
		// 关闭当前页面并传参
		optPartner(item){
			var pages = getCurrentPages();
			var prevPage = pages[pages.length - 2]; //上一个页面
			
			var data = {
				id : item.id,
				nickname : item.nickname,
				account : item.account,
			};
			prevPage.$vm.partnerInfo = data;
			uni.navigateBack();
		}
	}
};
</script>

<style>
@import url("../../style/partner_opt.css");
</style>
