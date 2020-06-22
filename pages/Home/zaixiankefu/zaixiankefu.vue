<template>
	
	<view style="overflow: hidden;">
		
		<scroll-view class="tab-title center" scroll-x="false" id="tab-title">
			<view>
				<view
					class="crcl-dda"
					v-for="(tab, index) in tabs"
					:key="index"
					:class="[tabCurrentIndex == index ? 'tab-current' : 'tabpage']"
					:id="'tabTag-' + index"
					@tap="tabChange"
				>
					{{ tab.name }}
				</view>
			</view>
		</scroll-view>
		
		<swiper class="tab-swiper-full" :current="swiperCurrentIndex" @change="swiperChange" :style="{ height: tabHeight + 'px' }">
			<swiper-item key="0">
				<zaixiankfu></zaixiankfu>
			</swiper-item>
			<swiper-item key="1">
				<chanpinshiyong :dataList="list"></chanpinshiyong>
			</swiper-item>
		</swiper>
	</view>
</template>

<script>
import Chanpinshiyong from '@/components/home/chanpinshiyong.vue';
import zaixiankfu from '@/components/home/zaixiankefu.vue';

import net from '../../../common/net.js';
export default {
	components: {
		Chanpinshiyong,
		zaixiankfu
	},
	data() {
		return {
			show: false,
			tabCurrentIndex: 0,
			swiperCurrentIndex: 0,
			titleShowId: 'tabTag-0',
			tabHeight: 300,
			tabs: [
				//标签名称 , 分类 id , 加载更多, 加载的页码
				{ name: '在线客服', id: 'pwd1', loadingType: 0, page: 1 },
				{ name: '产品使用', id: 'pwd2', loadingType: 0, page: 1 }
			],
			showKeyboard: false,
			
			// 获取常见问题列表
			list:[]
		};
	},
	
	onLoad() {
		// 获取常见问题列表
		this.getList();
	},
	
	methods: {
		close() {
			this.show = false;
		},
		tabChange(e) {
			var index = e.target.id.replace('tabTag-', '');
			this.swiperCurrentIndex = index;
			this.tabCurrentIndex = index;
			this.titleShowId = 'tabTag-' + index;
		},
		swiperChange: function(e) {
			var index = e.detail.current;
			this.tabCurrentIndex = index;
			this.titleShowId = 'tabTag-' + index;
		},
		
		
		// 获取列表数据
		getList(){
	    	net({
	        	url:"/V1/problem",
	            method:'get',
	            success: (res) => {
					this.list = res.data.success.data;
	            }
	      	})
		}
	},
	
	
	onReady() {
		//获取屏幕高度及比例
		var winInfo = uni.getSystemInfo({
			success: res => {
				var windowHeight = res.windowHeight;
				//获取头部标题高度
				var dom = uni.createSelectorQuery().select('#tab-title');
				dom.fields({ size: true }, res2 => {
					if (!res2) { return; }
					//计算得出滚动区域的高度
					this.tabHeight = windowHeight - res2.height;
				}).exec();
			}
		});
	}
};
</script>

<style>
@import '../style/service.css';
</style>
