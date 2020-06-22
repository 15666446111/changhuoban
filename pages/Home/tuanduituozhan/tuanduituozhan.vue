<template>
	<view>
		<!-- 用户组为代理时展示 -->
		<view v-if="userGroup == 2">
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
			
			<swiper class="tab-swiper-full" :current="swiperCurrentIndex" :style="{ height: tabHeight * 2.2 + 'px' }">
				<swiper-item key="0">
					
					<view class="body">
						<view class="container2">
							<swiper class="sw">
								<swiper-item>
									<image mode="aspectFit" @longpress="downloadImg(userPoster)" :src=userPoster class="img" ></image>
								</swiper-item>
							</swiper>
						</view>
						<button>长按图片保存</button>
					</view>
					
				</swiper-item>
				<swiper-item key="1">
					
					<view class="body">
						<view class="container2">
							<swiper class="sw">
								<swiper-item><image mode="aspectFit" :src=agentPoster class="img"></image></swiper-item>
							</swiper>
						</view>
						<button>长按图片保存</button>
					</view>
					
				</swiper-item>
			</swiper>
		</view>
		
		<!-- 用户组为用户时展示 -->
		<view class="body" v-if="userGroup == 1">
			<view class="container2">
				<swiper class="sw">
					<swiper-item><image mode="aspectFit" :src=userPoster class="img"></image></swiper-item>
				</swiper>
			</view>
			<button>长按图片保存</button>
		</view>
	</view>
</template>

<script>
import shareImages from '@/components/home/team-share-imgs.vue';

import net from '../../../common/net.js';

export default {
	components: {
		shareImages
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
				{ name: '用户推广', id: 'pwd1', loadingType: 0, page: 1 },
				{ name: '代理推广', id: 'pwd2', loadingType: 0, page: 1 }
			],
			showKeyboard: false,
			
			userPoster: '',
			agentPoster: '',
			userGroup: '',
		};
	},
	
	onLoad() {
		this.getUserInfo();
	},
	
	methods: {
		tabChange(e) {
			var index = e.target.id.replace('tabTag-', '');
			this.swiperCurrentIndex = index;
			this.tabCurrentIndex = index;
			this.titleShowId = 'tabTag-' + index;
		},
		
		// 获取当前登录用户信息
		getUserInfo(){
			net({
	        	url:"/V1/mine",
	            method:'get',
	            success: (res) => {
					this.userGroup = res.data.success.data.group_id;
					if (res.data.success.data.group_id == 1) {
						this.getUserPoster();
					} else {
						this.getUserPoster();
						this.getAgentPoster();
					}
	            }
	      	})
		},
		
		// 获取代理推广海报
		getAgentPoster(){
			net({
	        	url:"/V1/team_share",
	            method:'get',
	            success: (res) => {
					console.log(res);
					this.agentPoster = res.data.success.data.link;
	            }
	      	})
		},
		
		// 获取用户推广海报
		getUserPoster(){
			net({
	        	url:"/V1/user_share",
	            method:'get',
	            success: (res) => {
					this.userPoster = res.data.success.data.link;
	            }
	      	})
		},
		
		// 长按保存图片
		downloadImg(imageUrl){
			uni.downloadFile({
			    url: imageUrl,
			    success: (res) => {
			        if (res.statusCode === 200) {
						uni.saveImageToPhotosAlbum({
							filePath: res.tempFilePath,
							success: function() {
								uni.showToast({ title: "保存成功", icon: "none" });
							},
							fail: function() {
								uni.showToast({ title: "保存失败，请稍后重试", icon: "none" });
							}
						});
					}
			    }
			});
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
@import '../style/team_ext.css';
</style>
