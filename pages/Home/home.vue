<template>
	<view>
		<!-- 轮播图 -->
		<swiper-image :resdata="swipers"></swiper-image>
		
		<!-- 公告 -->
		<view class="notice" v-if="notice_show">
			<image class="notice-img" src="../../static/laba.png" mode="widthFix"></image>
			<navigator :url=" '../Article/ArtilcleDetail?aid=' + notice.id" style="width: 90%;">
				<view class="notice-text"> {{ notice.title}} </view>
			</navigator>
		</view>

		<!-- 首页分类 -->
		<home-nav :resdata="indexnavs"></home-nav>

		<!-- 数据显示 -->
		<view class="datas">
			<view class="data"> 
				<view class="deal">
					<view class="number">{{ info.MonthTrade}}</view>
					<view class="text">月交易额</view>
				</view>
				<view class="wire"></view>
				<view class="deal">
					<view class="number">{{ info.MonthIncome}}</view>
					<view class="text">本月收益</view>
				</view>
			</view>
			<view class="vertical"></view>
			<view class="data ">
				<view class="deal">
					<view class="number_orign">{{ info.MonthTeam}}</view>
					<view class="text">新增伙伴(人)</view>
				</view>
				<view class="wire"></view>
				<view class="deal">
					<view class="number_orign">{{ info.MonthMerchant}}</view>
					<view class="text">新增商户(户)</view>
				</view>
			</view>
			<navigator url=".."></navigator>
		</view>
		
	</view>
</template>

<script>
import swiperImage from '@/components/home/swiper-image.vue';
import homeNav from '@/components/home/home-nav.vue';

import net from '../../common/net.js';

export default {
	
	components: {
		swiperImage,
		homeNav
	},
	
	data() {
		return {
			// 轮播图
			swipers: [],
			// 公告信息
			notice:{},
			// 是否显示公告
			notice_show: false,
			
			// 统计信息
			info: {
				MonthTrade: 0,	// 月交易量
				MonthTeam:	0,	// 新增伙伴
				MonthIncome:0,  // 本月收益
				MonthMerchant:0,// 新增商户
			},
			
			indexnavs: [
				{ src: '/static/wd/jj.png', text: '机具管理', url: '/pages/mine/machinesInfo/machinesInfo' },
				{ src: '/static/2.png', text: '商户注册', url: '/pages/Home/mer_register/share_poster' },
				{ src: '/static/3.png', text: '商户登记', url: '/pages/Home/machineReg/machineReg' },
				{ src: '/static/13.png', text: '商户管理', url: '/pages/Home/shanghuguanli/machineInfo' },
				{ src: '/static/5.png', text: '商城购买', url: '' },
				{ src: '/static/4.png', text: '团队拓展', url: '/pages/Home/team_expand/team_expand' },
				{ src: '/static/44.png', text: '伙伴管理', url: '/pages/Home/huobanguanli/friendsInfo' },
				{ src: '/static/8.png', text: '在线客服', url: '' }
			]
		};
	},
	
	// 页面初始化执行
	onLoad(){
		// 获取轮播图
		this.getSwipers();
		// 获取公告信息
		this.getNotice();
		// 获取首页统计信息
		this.getHomeInfo();
	},
	
	//监听下拉刷新动作的执行方法，每次手动下拉刷新都会执行一次
    onPullDownRefresh() {
		// 获取轮播图
		this.getSwipers();
		// 获取公告信息
		this.getNotice();
		// 获取首页统计信息
		this.getHomeInfo();
		
        setTimeout(function () {
            uni.stopPullDownRefresh();  //停止下拉刷新动画
        }, 2000);
	},
	
	methods: {	
		// 获取轮播图
	  	getSwipers(){
	    	net({
	        	url:"/V1/plug",
	            method:'get',
				data:{type:1},
	            success: (res) => {
					if (res.data.success && res.data.success.data) this.swipers = res.data.success.data;
					else uni.showToast({ title: res.data.error.message, icon: 'none' });
	            }
	      	})
		},
		
		// 获取公告信息
		getNotice(){
	    	net({
	        	url:"/V1/notice",
	            method:'get',
				data:{type_id:1},
	            success: (res) => {
					if(res.data.success.data){
						this.notice = res.data.success.data;
						this.notice_show = true;
					}
					else uni.showToast({ title: res.data.error.message, icon: 'none' });
	            }
	      	})
		},
		
		// 获取首页统计信息
	  	getHomeInfo(){
	    	net({
	        	url:"/V1/index_info",
	            method:'get',	
	            success: (res) => {
					if(res.data.success && res.data.success.data) this.info = res.data.success.data;
					else uni.showToast({ title: res.data.error.message, icon: 'none' });
	            }
	      	})
		}
	}
	

};
</script>

<style>
@import 'style/shouye.css';
</style>
