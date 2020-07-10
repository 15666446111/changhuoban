<template>
	<view id="body">
		<!-- 搜索框 -->
		<view class="sousuo">
			<view class="sousuo-view">
				<image class="input-image" src="/static/left_fdj.png" mode="aspectFit"></image>
				<input class="input" placeholder="请正确输入伙伴手机号" />
			</view>
		</view>
		
		<view class="select">
			<!-- 内容 -->
			<view class="content" v-if="team.length != 0">
				<view v-for="(item,index) in team" :key="item.id">
					<navigator  hover-class="none"  :url="'/pages/Home/huobanguanli/friendList/friendList?user='+item.id">
					<view class="detail">
							<image :src="item.avatar" class="detail-image"/>
							<view class="partner">
								<view class="detail-name">{{ item.nickname}}</view>
							</view>
							<view class="money">
								<view class="money-text">注册时间：{{ item.created_at}}</view>
							</view>
							<image src="/static/jiantou.png" class="money-image"></image>
					</view>
					</navigator>
				</view>
			</view>
			
			<view v-if="team.length ==0" style="padding-top: 200rpx; color:#999; text-align: center;">
				暂无伙伴数据哦～
			</view>
		</view>
	</view>
</template>

<script>
import net from '../../../common/net.js';

export default {
	data() {
		return {
			team: [],
		};
	},
	
	onLoad(){
		// 获取我的下级列表
		this.getTeamList();
	},
	
	methods: {
		getTeamList(){
	    	net({
	        	url:"/V1/my_team",
	            method:'get',
	            success: (res) => {
					console.log(res)
					this.team = res.data.success.data.list;
	            } 
	      	})
		}
	}
};
</script>

<style>
@import '../style/team_manage.css';
</style>
