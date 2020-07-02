<template>
	<view>
		<!-- 顶部选项卡 -->
		<scroll-view scroll-x class="border-bottom scroll-row" style="height: 80rpx;" :scroll-into-view="srcollinto" scroll-with-animation="true">
			<view
				class="scroll-row-item px-3 "
				@click="changTab(index)"
				style="height: 80rpx; line-height: 80rpx;"
				v-for="(item, index) in typeList"
				:key="index"
				:class="tabIndex === index ? 'main-text-color' : ''"
				:id="'tab' + index"
			>
				<text class="font-md">{{ item.name }}</text>
			</view>
		</scroll-view>
		
		<swiper :current="tabIndex" :duration="150" disable-touch="true" :style="'height:' + scrollH + 'px'">
			<swiper-item v-for="(item, index) in typeList" :key="index">
				
				<!-- 厂商 -->
				<scroll-view scroll-x class="border-bottom scroll-row " style="height: 80rpx;" :scroll-into-view="srcollinto_f" scroll-with-animation="true">
					<view
						class="scroll-row-item px-3 "
						@click="changTab1(index)"
						style="height: 80rpx; line-height: 80rpx;"
						v-for="(item, index) in factiryList"
						:key="index"
						:class="tabIndexFac === index ? 'main-text-color' : ''"
						:id="'tab' + index"
					>
						<text class="font-md">{{ item.factory_name }}</text>
					</view>
				</scroll-view>
				
				<swiper :current="tabIndexFac" :duration="150" disable-touch="true" :style="'height:' + scrollH + 'px'">
					<swiper-item v-for="(item, index) in factiryList" :key="index">
						
						<!-- 型号 -->
						<scroll-view scroll-x class="border-bottom scroll-row" style="height: 80rpx;" :scroll-into-view="srcollinto_s" scroll-with-animation="true">
							<view
								class="scroll-row-item px-3 "
								@click="changTab2(index)"
								style="height: 80rpx; line-height: 80rpx;"
								v-for="(item, index) in styleList"
								:key="index"
								:class="tabIndexStyle === index ? 'main-text-color' : ''"
								:id="'tab' + index"
							>
								<text class="font-md">{{ item.style_name }}</text>
							</view>
						</scroll-view>
						
						<!-- 产品 -->
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
			srcollinto_f: '',
			srcollinto_s: '',
			
			scrollH: 500,
			
			tabIndex: 0,
			tabIndexFac: 0,
			tabIndexStyle: 0,
			
			typeList: [],		// 产品类型
			factiryList: [],	// 产品厂商
			styleList: [],		// 产品型号
			product: []			// 产品
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

	//监听下拉刷新动作的执行方法，每次手动下拉刷新都会执行一次
    onPullDownRefresh() {
		uni.showLoading();
		// 页面加载的时候获取产品分类
		this.getProductType();
		//获取可视区域高度
		uni.getSystemInfo({
			success: res => { this.scrollH = res.windowHeight - uni.upx2px(80); }
		});
	},
	
	methods: {
		// 获取产品类型信息
	  	getProductType(){
	    	net({
	        	url:"/V1/getproducttype",
	            method:'get',
	            success: (res) => {
					uni.hideLoading();
					this.typeList = res.data.success.data;
					// 获取厂商信息
					this.changTab(0);
	            }
	      	})
		},
		
		
		// 切换选项卡
		changTab(index) {
			uni.showLoading();
			// if (this.tabIndex == index) return;
			this.tabIndex = index;
			this.srcollinto = 'tab' + index;
			// 请求数据
			const type = this.typeList[index].id
			
	    	net({
	        	url:"/V1/getproductfactories",
	            method:'get',
				data: { type: type},
	            success: (res) => {
					// console.log(res);
					uni.hideLoading();
					this.factiryList = res.data.success.data;
					this.changTab1(0);
	            }
	      	})
	
		},
		
		// 获取型号信息
		changTab1(index) {
				uni.showLoading();
				this.tabIndexFac = index;
				this.srcollinto_f = 'tab' + index;
				
				if (this.factiryList[index] != undefined) {
					// 请求数据
					const type = this.factiryList[index].id;
			    	net({
			        	url:"/V1/getproductstyles",
			            method:'get',
						data: { factoriy: type},
			            success: (res) => {
							// console.log(res);
							this.styleList = res.data.success.data;
							this.changTab2(0);
			            }
			      	})
				} else {
					uni.hideLoading();
				}
			},
			
		// 获取产品信息
		changTab2(index) {
				uni.showLoading();
				// if (this.tabIndex == index) return;
				this.tabIndexStyle = index;
				this.srcollinto_s = 'tab' + index;
				
				if (this.styleList[index] != undefined) {
					// 请求数据
					const type = this.styleList[index].id
			    	net({
			        	url:"/V1/getproduct",
			            method:'get',
						data: { style: type},
			            success: (res) => {
							uni.hideLoading();
							this.product = res.data.success.data;
			            }
			      	})
				} else {
					uni.hideLoading();
					this.product = [];
				}
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
