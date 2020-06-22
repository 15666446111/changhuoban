<template>
	<view>
		<!-- 顶部选项卡 -->
		<scroll-view scroll-x class="border-bottom scroll-row" style="height: 100rpx;" :scroll-into-view="srcollinto" scroll-with-animation="true">
			<view
				class="scroll-row-item px-3 "
				@click="changTab(index)"
				style="height: 80rpx; line-height: 80rpx;"
				v-for="(item, index) in tabBars"
				:key="index"
				:class="tabIndex === index ? 'main-text-color' : ''"
				:id="'tab' + index"
			>
				<text class="font-md">{{ item.brand_name }}</text>
			</view>
		</scroll-view>

		<swiper :current="tabIndex" :duration="150" :style="'height:' + scrollH + 'px'">
			<swiper-item v-for="(item, index) in tabBars" :key="index">
				<scroll-view scroll-y="true" :style="'height:' + scrollH + 'px'">
					<view class="body">
						<view class="list-wrap">
							<scroll-view scroll-y="true" class="list">
								<view class="list-scroll-view">
									
									<view class="course-card" v-for="(item, index) in product" :key="index">
										<navigator :url="'shangpingxinxi/shangpingxinxi?product='+item.id">
											<view>
												<image :src=item.image mode="widthFix"></image>
											</view>
											<view class="body-text">{{item.title}}</view>
											<view class="price">¥{{item.price / 100}}</view>
										</navigator>
									</view>
													
								</view>
							</scroll-view>
						</view>
					</view>
				</scroll-view>
			</swiper-item>
		</swiper>
	</view>
</template>

<script>
import net from '../../../common/net.js';	
	
export default {
	data() {
		return {
			srcollinto: '',
			scrollH: 500,
			tabIndex: 0,
			tabBars: [],
			product: []
		};
	},
	onLoad() {
		uni.showLoading();
		// 页面加载的时候获取产品分类
		this.getProductType();
		//获取可视区域高度
		uni.getSystemInfo({
			success: res => { this.scrollH = res.windowHeight - uni.upx2px(80); }
		});
	},
	
	methods: {
		// 获取产品分类信息
	  	getProductType(){
	    	net({
	        	url:"/V1/getproducttype",
	            method:'get',
	            success: (res) => {
					uni.hideLoading();
					this.tabBars = res.data.success.data;
					// 获取商品信息
					this.changTab(0);
	            }
	      	})
		},
		
		
		// 切换选项卡
		changTab(index) {
			// if (this.tabIndex == index) return;
			this.tabIndex = index;
			this.srcollinto = 'tab' + index;
			// 请求数据
			const type = this.tabBars[index].id
			
	    	net({
	        	url:"/V1/getproduct",
	            method:'get',
				data: { type: type},
	            success: (res) => {
					// console.log(res);
					this.product = res.data.success.data;
	            }
	      	})
	
		},
		
		onChangeTab(e) {
			this.changTab(e.detail.current);
		}
	}
};
</script>

<style>
@import '../style/shop.css';
</style>
