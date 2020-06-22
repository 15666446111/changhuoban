<template>
	<view>
		<!-- 头部 -->
		<view class="titlebars">
			
			<view class="titlebar">
				<view class="rise"> 
					<view class="rise-head">
						<image class="head" :src="UserInfo.heading" mode="aspectFill" />
						<view class="name">{{ UserInfo.nickname}}</view>
					</view>
					<view class="ID">{{ UserInfo.username }}</view>
				</view>
			</view>

			<view class="earnings">
				
				<navigator url="lijitixian/lijitixian">
					<view class="tixian">提现</view>
				</navigator>
				
				<view class="earning blance_title">
					<text>总资产(元)</text>
				</view>
				
				<view class="earning blance_text">
					<text style="">{{ UserInfo.blance / 100 | numberGSH }}</text>
				</view>
				
				<view class="across"></view>

				<view class="eings d-flex">
					<view class="eings-view">
						<view style="color: #666;">分润钱包(元)</view>
						<view style="color: #EE9900;">{{UserInfo.cash_blance/100 | numberGSH }}</view>
					</view>
					<view class="shuxian"></view>
					<view class="eings-view">
						<view style="color: #666;">返现钱包(元)</view>
						<view style="color: #EE9900;">{{UserInfo.return_blance/100 | numberGSH }}</view>
					</view>
				</view>
			</view>
		</view>
		<!-- 头部数据框 -->
		<!-- 内容 -->
		<view class="NavigationBar">
			<view class="Bar1">
				
				<navigator class="url" url="jijuguanli/jijuguanli">
					<view class="div">
						<image class="div-img" src="/static/wd/jj.png" />
						<view class="div-text">机具管理</view>
						<image class="arrows" src="/static/jiantou.png" />
					</view>
					<view class="across"></view>
				</navigator>
				
				<navigator class="url" url="wodedingdan/wodedingdan">
					<view class="div">
						<image class="div-img" src="/static/wd/sh.png" />
						<view class="div-text">我的订单</view>
						<image class="arrows" src="/static/jiantou.png" />
					</view>
					<view class="across"></view>
				</navigator>
				
				<view class="across"></view>
				
				<navigator class="url" :url="'wodezhengc/wodezhengc?uid=' + UserInfo.id">
					<view class="div">
						<image class="div-img" src="/static/wd/cp.png" />
						<view class="div-text">我的政策</view>
						<image class="arrows" src="/static/jiantou.png" />
					</view>
					<view class="across"></view>
				</navigator>

				<view class="across"></view>
				

				<navigator class="url" :url="'share/wx_share?uid=' + UserInfo.id">
					<view class="div">
						<image class="div-img" src="/static/wx.png" />
						<view class="div-text">微信分享</view>
						<image class="arrows" src="/static/jiantou.png" />
					</view>
					<view class="across"></view>
				</navigator>
				<view class="across"></view>
				
				<navigator class="url" url="temail_share/temail_share">
					<view class="div">
						<image class="div-img" src="/static/yaoqing.png" />
						<view class="div-text">推广商户</view>
						<image class="arrows" src="/static/jiantou.png" />
					</view>
					<view class="across"></view>
				</navigator>
				<view class="across"></view>				
				
				<navigator class="url" url="../shouye/zaixiankefu/zaixiankefu">
					<view class="div">
						<image class="div-img" src="/static/wd/kf.png" />
						<view class="div-text">在线客服</view>
						<image class="arrows" src="/static/jiantou.png" />
					</view>
					<view class="across"></view>
				</navigator>

				<navigator class="url" url="xiaoxitongzhi/xiaoxitongzhi">
					<view class="div">
						<image class="div-img" src="/static/wd/xiaoxi.png" />
						<view class="div-text">消息通知</view>
						<image class="arrows" src="/static/jiantou.png" />
					</view>
					<view class="across"></view>
				</navigator>
				<navigator class="url" url="shezhi/shezhi">
					<view class="div">
						<image class="div-img" src="/static/xtsz.png" />
						<view class="div-text">系统设置</view>
						<image class="arrows" src="/static/jiantou.png" />
					</view>
					<view class="across"></view>
				</navigator>
				
			</view>
			<!-- 第三 -->
			<view class="Bar1"></view>
		</view>
		<view style="height: 110upx;"></view>
	</view>
</template>
<script>
import net from '../../common/net.js';

export default {
	data() {
		return {
			UserInfo: {
				'headimg' : null,
				'nickname': null,
				'username': null,
				'blance': '0.00',
				'cash_blance': '0.00',
				'return_blance': '0.00',
			}
		}
	},
		
	// 初始化数据
	onLoad(){
		uni.showLoading();
	},
	
	onShow() {
		this.getUserInfo();
	},

	methods: {
		// 获取个人信息
	  	getUserInfo(){
	    	net({
	        	url:"/V1/userInfo",
	            method:'get',
	            success: (res) => {
					uni.hideLoading();
					console.log(res);
					this.UserInfo = res.data.success.data;
	            }
	      	})
		},
	},
	filters: {
		numberGSH(value){
			return value.toFixed(2)
		}
	}
};
</script>

<style>
@import 'style/mine.css';
</style>
