<template>
	<view>
		<!-- 选择栏 -->
		<view class="head">
			<image class="head-img" :src=productInfo.image mode="widthFix" />
		</view>
		
		<!-- 价格 -->
		<view class="head-view">
			<view class="head-text">{{productInfo.title}}</view>
			<view class="head-money">¥{{ productInfo.price / 100 }}</view>
		</view>
		
		<!-- 详情 -->
		<view class="xian"></view>
		<view class="xian-text">商品详情</view>
		<view class="content">
			<rich-text :nodes="productInfo.content|formatRichText"></rich-text>
		</view>

		<!-- 底部 -->
		<!-- <view style="height: 100upx;"></view> -->
		
		<view class="d-flex a-stretch bg-white position-fixed left-0 right-0 bottom-0" style="height: 100upx; z-index: 100;">
			<view class="d-flex flex-column a-center j-center line-h-md " style="flex: 1.5; color: red;" hover-class="bg-light-secondary">
				价格:￥{{ productInfo.price / 100 }}
			</view>
			<!-- -->
			<view class="d-flex flex-column a-center j-center line-h-md main-bg-color text-white" style="flex: 1; background-color: red;" @click="show">立即购买</view>
			<!--</navigator>-->
		</view>
		<!-- 底部弹出框 -->
		<common-popup :popupClass="popupClass" @hide="hide">
			<!-- 弹出框内容 -->
			<view class="d-flex a-center" style="height: 275rpx;">
				<image :src=productInfo.image mode="widthFix" style="width: 180rpx; height: 180rpx;" class="border rounded"></image>
				<view class="pl-2">
					<Price priceSize="font-lg" unitSize="font">￥{{ productInfo.price / 100 }}</Price>
					<text class="d-block">{{ productInfo.title }}</text>
				</view>
			</view> 
			<view class="select"> 
				<view class="type">名称</view>
				<view class="MP70">{{ productInfo.title }}</view>
				<view class="select-view"></view>
				<view class="d-flex j-sb a-center">
					<text>购买数量</text>
					<uni-number-box :min="1" :value="num" @change="num=$event"></uni-number-box>
				</view>
				 
				<navigator :url="'../querendingdan/querendingdan?product='+productInfo.id+'&num='+num">
					<view 
						class="main-bg-color text-white font-md d-flex a-center j-center" hover-class="main-bg-hover-color">
						立即购买
					</view>
				</navigator>
			</view>
		</common-popup>
	</view>
</template>

<script>
import commonPopup from '@/components/common/common-popup.vue';
import radioGroup from '@/components/common/radio-group.vue';
import uniNumberBox from '@/components/uni-ui/uni-number-box/uni-number-box.vue';

import net from '../../../../common/net.js';

export default {
	
	components: { commonPopup, radioGroup, uniNumberBox },
	
	data() {
		return {
			num:"1",
			max:'5',
			label: {
				selected: 0,
				list: [{ name: 'MP70普通版(3台)' }]
			},
			popupClass: 'none',
			
			productInfo: {},
		};
	},
	
	onLoad: function (options){
		// 获取产品信息
		this.getProductInfo(options.product);
	},
	
	methods: {
		// 获取产品信息
		getProductInfo(index) {
	    	net({
	        	url:"/V1/getproductinfo",
	            method:'get',
				data:{ product: index},
	            success: (res) => {
					console.log(res)
					this.productInfo = res.data.success.data;
	            }
	      	})
		},
		
		
		
		hide() {
			this.popupClass = 'hide';
			setTimeout(() => {
				this.popupClass = 'none';
			}, 200);
		},
		show() {
			this.popupClass = 'show';
		}
	},
	
	filters: {
		/**
		 * 处理富文本里的图片宽度自适应
		 * 1.去掉img标签里的style、width、height属性
		 * 2.img标签添加style属性：max-width:100%;height:auto
		 * 3.修改所有style里的width属性为max-width:100%
		 * 4.去掉<br/>标签
		 * @param html
		 * @returns {void|string|*}
		 */
		formatRichText (html) { //控制小程序中图片大小
			let newContent= html.replace(/<img[^>]*>/gi,function(match,capture){
				match = match.replace(/style="[^"]+"/gi, '').replace(/style='[^']+'/gi, '');
				match = match.replace(/width="[^"]+"/gi, '').replace(/width='[^']+'/gi, '');
				match = match.replace(/height="[^"]+"/gi, '').replace(/height='[^']+'/gi, '');
				return match;
			});
			newContent = newContent.replace(/style="[^"]+"/gi,function(match,capture){
				match = match.replace(/width:[^;]+;/gi, 'max-width:100%;').replace(/width:[^;]+;/gi, 'max-width:100%;');
				return match;
			});
			newContent = newContent.replace(/<br[^>]*\/>/gi, '');
			newContent = newContent.replace(/\<img/gi, '<img style="max-width:100%;height:auto;display:inline-block;margin:10rpx auto;"');
			return newContent;
		}	
	},
			
};
</script>
<style>
@import '../../style/product_detail.css';
</style>
