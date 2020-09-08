<template>
	<view>
		<!-- 头部 -->
		<view class="titlebars">
			
			<view class="titlebar">
				<view class="rise"> 
					<view class="rise-head">
						<image class="head" :src="UserInfo.heading" @click="changeAvatar()" mode="aspectFill" />
						<view class="name">账号:{{ UserInfo.account}}</view>
					</view>

					<view class="ID">昵称:{{ UserInfo.nickname }}<text class="user_group" v-if="type === 1"> 级别:{{ UserInfo.group }}</text></view>

				</view>
			</view>

			<view class="earnings">
				
				<navigator  hover-class="none"  url="cash/cash">
					<view class="tixian">提现</view>
				</navigator>
				
				<view class="earning blance_title">
					<text>总资产(元)</text>
				</view>
				
				<view class="earning blance_text">
					<text style="">{{ UserInfo.blance }}</text>
				</view>
				
				<view class="across"></view>

				<view class="eings d-flex">
					<view class="eings-view">
						<view style="color: #666;">分润钱包(元)</view>
						<view style="color: #EE9900;">{{UserInfo.cash_blance }}</view>
					</view>
					<view class="shuxian"></view>
					<view class="eings-view">
						<view style="color: #666;">返现钱包(元)</view>
						<view style="color: #EE9900;">{{UserInfo.return_blance }}</view>
					</view>
				</view>
			</view>
		</view>
		<!-- 头部数据框 -->
		
		
		<!-- 内容 -->
		<view class="NavigationBar">
			<view class="Bar1">
				
				<navigator  hover-class="none"  class="url" url="machinesInfo/machinesInfo">
					<view class="div">
						<image class="div-img" src="/static/wd/jj.png" />
						<view class="div-text">机具管理</view>
						<image class="arrows" src="/static/jiantou.png" />
					</view>
					<view class="across"></view>
				</navigator>
				
				<navigator  hover-class="none"  class="url" url="order/order">
					<view class="div">
						<image class="div-img" src="/static/wd/sh.png" />
						<view class="div-text">我的订单</view>
						<image class="arrows" src="/static/jiantou.png" />
					</view>
					
				</navigator>
				
				<view class="across"></view>
				
				<!--
				<navigator  hover-class="none"  class="url" :url="'wodezhengc/wodezhengc?uid=' + UserInfo.id">
					<view class="div">
						<image class="div-img" src="/static/wd/cp.png" />
						<view class="div-text">我的政策</view>
						<image class="arrows" src="/static/jiantou.png" />
					</view>
					<view class="across"></view>
				</navigator>

				<view class="across"></view>
				-->

				<navigator  hover-class="none"  class="url" :url="'share/wechat_share?uid=' + UserInfo.id">
					<view class="div">
						<image class="div-img" src="/static/wx.png" />
						<view class="div-text">微信分享</view>
						<image class="arrows" src="/static/jiantou.png" />
					</view>
					
				</navigator>
				<view class="across"></view>
				
				<!--
				<navigator  hover-class="none"  class="url" url="temail_share/temail_share">
					<view class="div">
						<image class="div-img" src="/static/yaoqing.png" />
						<view class="div-text">推广商户</view>
						<image class="arrows" src="/static/jiantou.png" />
					</view>
					<view class="across"></view>
				</navigator>
				<view class="across"></view>				
				-->
				
				<navigator  hover-class="none"  class="url" url="../Home/zaixiankefu/zaixiankefu">
					<view class="div">
						<image class="div-img" src="/static/wd/kf.png" />
						<view class="div-text">在线客服</view>
						<image class="arrows" src="/static/jiantou.png" />
					</view>
					<view class="across"></view>
				</navigator>

				<navigator  hover-class="none"  class="url" url="xiaoxitongzhi/xiaoxitongzhi">
					<view class="div">
						<image class="div-img" src="/static/wd/xiaoxi.png" />
						<view class="div-text">消息通知</view>
						<image class="arrows" src="/static/jiantou.png" />
					</view>
					<view class="across"></view>
				</navigator>
				<navigator  hover-class="none"  class="url" url="bankSet/bankSet">
					<view class="div">
						<image class="div-img" src="/static/xtsz.png" />
						<view class="div-text">系统设置</view>
						<image class="arrows" src="/static/jiantou.png" />
					</view>
					
				</navigator>
				
			</view>
			<!-- 第三 -->
			<view class="Bar1"></view>
		</view>
		<view style="height: 110upx;"></view>
		
		<view class="cu-load load-modal" v-if="loadModal.show">
		   <image src="/static/public/loading.png" mode="aspectFit"></image>
		   <view class="gray-text">{{ loadModal.text }}</view>
		</view>
	</view>
</template>
<script>
import net from '../../common/net.js';

export default {
	data() {
		return {
			loadModal: {
				show: false,
				text: '加载中...'
			},
			type: '',
			UserInfo: {
				'headimg' : null,
				'nickname': null,
				'username': null,
				'blance': '0.00',
				'cash_blance': '0.00',
				'return_blance': '0.00',
				'file':[]
			}
		}
	},
		
	// 初始化数据
	onLoad(){
		this.type 	= uni.getStorageSync('type');
	},
	
	onShow() {
		this.loadModal.show = true;
		this.getUserInfo();
	},
	
	//监听下拉刷新动作的执行方法，每次手动下拉刷新都会执行一次
	onPullDownRefresh() {
		this.loadModal.show = true;
		this.getUserInfo();
		
	    setTimeout(function () {
	        uni.stopPullDownRefresh();  //停止下拉刷新动画
	    }, 2000);
	},

	methods: {
		// 获取个人信息
	  	getUserInfo(){
	    	net({
	        	url:"/V1/userInfo",
	            method:'get',
	            success: (res) => {
					this.loadModal.show = false;
					this.UserInfo = res.data.success.data;
	            }
	      	})
		},
		changeAvatar(){
			var that =this;
			uni.chooseImage({
				count: 1,
				//可以指定是原图还是压缩图，默认二者都有
				sizeType: ['original', 'compressed'], 
				//从相册选择
				sourceType: ['album'], 
				success: function (res) {
					const tempFilePaths = res.tempFilePaths;
					// 获取token
					const token   = uni.getStorageSync('token');
					const uploadTask = uni.uploadFile({
						url : 'http://livechb3.changhuoban.com/api/V1/editAvatar',
						header: {'Authorization' : 'Bearer ' + token},
						filePath: tempFilePaths[0],
						name: 'file',
						dataType: 'json',
						success: function (uploadFileRes) {
							var result = JSON.parse(uploadFileRes.data);
							if(result.success && result.success.link){
								uni.showToast({ title: result.success.message, icon: 'none', position: 'bottom' })
								//console.log(that.UserInfo.heading)
								that.UserInfo.heading = result.success.link;
								//console.log(that.UserInfo.heading)
								//that.$forceUpdate();
							}else{
								uni.showToast({
									title:result.error.message,
									icon: 'none',
									position: 'bottom'
								})
							}
						}
					})
				},
			});
		},
	},
	filters: {
		// numberGSH(value){
		// 	return value.toFixed(2)
		// }
	}
};
</script>

<style>
@import 'style/mine.css';
</style>
