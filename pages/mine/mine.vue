<template>
	<view>
		<!-- 头部 -->
		<view class="titlebars">
			
			<view class="titlebar">
				<view class="rise"> 
					<view class="rise-head">
						<image class="head" :src="UserInfo.heading" @click="changeAvatar(UserInfo.heading)" mode="aspectFill" />
						<view class="name">账号:{{ UserInfo.account}}</view>
					</view>

					<view class="ID">昵称:{{ UserInfo.nickname }}  级别:{{ UserInfo.group }}</view>

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
					<text style="">{{ UserInfo.blance | numberGSH }}</text>
				</view>
				
				<view class="across"></view>

				<view class="eings d-flex">
					<view class="eings-view">
						<view style="color: #666;">分润钱包(元)</view>
						<view style="color: #EE9900;">{{UserInfo.cash_blance | numberGSH }}</view>
					</view>
					<view class="shuxian"></view>
					<view class="eings-view">
						<view style="color: #666;">返现钱包(元)</view>
						<view style="color: #EE9900;">{{UserInfo.return_blance | numberGSH }}</view>
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
				
				<navigator  hover-class="none"  class="url" url="wodedingdan/wodedingdan">
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
				'file':[]
			}
		}
	},
		
	// 初始化数据
	onLoad(){
		
		uni.showLoading();
		this.getUserInfo();
		
	},
	
	//监听下拉刷新动作的执行方法，每次手动下拉刷新都会执行一次
	onPullDownRefresh() {
		uni.showLoading();
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
					uni.hideLoading();
					console.log(res);
					this.UserInfo = res.data.success.data;
	            }
	      	})
		},
		// changeAvatar(heading){
		//         uni.showActionSheet({
		//         // itemList按钮的文字接受的是数组
		//           itemList: ["查看头像","从相册选择图片"],
		//           success(e){
		//             var index = e.tapIndex
		//             if(index === 0){
		//             // 用户点击了预览当前图片
		//             // 可以自己实现当前头像链接的读取
		//               let url  = heading
		//               let arr=[]
		//               arr.push(url)
		//               uni.previewImage({
		//               // 预览功能图片也必须是数组的
		//                 urls: arr
		//               })
		//             }else if(index === 1){
		//             // 用户点击了从图库上传
		//               uni.chooseImage({
		//                 count: 1,
		//                 sizeType: ["compressed"],
		//                 success(response) {
							
		//                 // 选择图片后, 返回的数据
		// 				   var file =[];
		//                    file = response.tempFiles[0]
		// 				   // console.log(file);return;
		// 				   var formData = new FormData();
		// 				   formData.append('file',response.tempFiles[0]);
		// 				   uni.uploadFile({
		// 					   url: 'http://3.changhuoban.com/api/V1/updateUserInfo', 
		// 					   filePath: tempFilePaths[0],
		// 					   name: 'file',
		// 					   formData: {
		// 						   'user': 'test'
		// 					   },
		// 					   success: (uploadFileRes) => {
		// 						   console.log(uploadFileRes.data);
		// 					   }
		// 				   });
		// 					net({
		// 			         	 url:"/V1/updateUserInfo",
		// 			             method:'post',
		// 						 data:formData,
		// 						 header:{"Content-Type": "multipart/form-data"},
		// 			             success: (res) => {
		// 							uni.hideLoading();
		// 							if (res.data.success) {
		// 								uni.showToast({
		// 									title: res.data.success.message,
		// 									icon: 'none',
		// 									success : function(){
		// 										setTimeout(function() {
		// 											uni.navigateBack();
		// 										}, 1500);
		// 									}
		// 								});
		// 							} else {
		// 								uni.showToast({
		// 									title: res.data.error.message,
		// 									icon: 'none'
		// 								});
		// 							}
		// 			             }
		// 			       	})
		//                 }
		//               })
		//             }
		//         }
		// 	})
		// }
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
