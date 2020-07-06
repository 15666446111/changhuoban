<template>
	<view>
		<view v-if="article.length != 0">
			<view class="title">
				<text>{{article.title}}</text>
			</view>
			<view class="add_time">
				发布时间：{{article.created_at}}
			</view>
			<view class="content">
				<rich-text :nodes="article.content|formatRichText"></rich-text>
			</view>
		</view>
		
		<view v-if="article.length == 0"  style="height: 100%;  display: flex; justify-content: center;align-items: center; background-color: #f5f5f5;">
			<image src="/static/no-data.jpeg" mode="widthFix"></image>
		</view>
		
	</view>
	
</template>

<script>
	import net from '../../common/net.js';

	export default {
		data() {
			return {
				article: {ci : 0 }
			};
		},
		
		// 页面初始化执行
		onLoad(options){
			uni.showLoading()
			this.getArticle(options.aid);
		},
		
		methods: {
			getArticle(aid){
				net({	
		        	url:"/V1/article",
		            method:'get',
					data:{aid:aid},
		            success: (res) => {
						console.log(res.data.success.data);
						uni.hideLoading()
						if(res.data.success && res.data.success.data){
							this.article = res.data.success.data;
						}else{
							uni.showToast({
								title: res.data.error.message,
								icon:'none',
								position: 'bottom'
							})
						}
		            } 
		      	})
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
	}
</script>

<style>
	page {
		background-color: #f7f7f7;
		padding: 0 4%;
	}
	.title {
		height: 100rpx;
		line-height: 100rpx;
		font-size: 34rpx;
		text-align: center;
	}
	.add_time {
		padding-bottom: 20rpx;
		text-align: right;
		fong-size: 24rpx;
		color: #999;
	}
	.content {
		//text-indent: 44rpx;
	}
	.content img {
		max-width: 100%;
	}
</style>
