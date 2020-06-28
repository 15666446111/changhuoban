<template>
	<view class="body-gy">
		<!-- 头部数据框 -->
		<view class="titlebars">
			<view class="earnings">
				<view class="earning">
					<view class="earning-text">总收益(元)</view>
					<view class="earning-figure">{{ data.revenueAll / 100 | 0}}</view>
				</view>
				<view class="across1"></view>
				<view class="button">
					<view class="button-view">
						<view class="button-text">今日收益(元)</view>
						<view class="button-figure">{{ data.revenueDay / 100 | 0}}</view>
					</view>
					<view class="button-vertical"></view>
					<view class="button-view">
						<view class="button-text">本月收益(元)</view>
						<view class="button-figure">{{ data.revenueMonth / 100 | 0}}</view>
					</view>
				</view>
			</view>
		</view>
		<!-- 选择框 -->
		<view class="dis-fix" style="height: 80rpx;" :scroll-into-view="srcollinto" scroll-with-animation="true">
			<view
				class="dis-div"
				@click="changTab(index)"
				style="height: 80rpx; line-height: 80rpx;"
				v-for="(item, index) in useName"
				:key="index"
				:class="tabIndex === index ? 'main-text-color' : ''"
				:id="'tab' + index"
			>
				<text class="dis-text">{{ item.name }}</text>
				<text :class="index < IndexClass ? 'shuxian1' : ''"></text>
			</view>
		</view>

		<!-- 内容栏 -->
		<view class="content" v-for="(item, index) in data.cash" :key="index">
			<view class="times">
				<view class="time">{{ item.title }} {{ item.week }}</view>
				<view class="income">收入¥{{ item.money / 100 | 0 }}</view>
			</view>
			<view class="across"></view>
			<view class="for" v-for="(t,d) in item.list" :key="d">
				<view class="detail">
					<image class="detail-img" v-if="t.type == 1" src="/static/sy/zhi.png"  />
					<view class="detail-name" v-if="t.type == 1">直营分润</view>
					
					<image class="detail-img" v-if="t.type == 2" src="/static/sy/zhi.png"  />
					<view class="detail-name" v-if="t.type == 2">团队分润</view>
					
					<image class="detail-img" v-if="t.type == 3" src="/static/sy/zhi.png"  />
					<view class="detail-name" v-if="t.type == 3">激活返现</view>
					
					<image class="detail-img" v-if="t.type == 4" src="/static/sy/zhi.png"  />
					<view class="detail-name" v-if="t.type == 4">间推激活返现</view>
					
					
					<image class="detail-img" v-if="t.type == 5" src="/static/sy/fan.png"  />
					<view class="detail-name" v-if="t.type == 5">间间推激活返现</view>
					
					
					<image class="detail-img" v-if="t.type == 6" src="/static/sy/fan.png"  />
					<view class="detail-name" v-if="t.type == 6">达标返现</view>
					
					<image class="detail-img" v-if="t.type == 7" src="/static/sy/fan.png"  />
					<view class="detail-name" v-if="t.type == 7">二次达标返现</view>
					
					
					<image class="detail-img" v-if="t.type == 8" src="/static/sy/fan.png"  />
					<view class="detail-name" v-if="t.type == 8">三次达标返现</view>
					
					<image class="detail-img" v-if="t.type == 9" src="/static/sy/fan.png"  />
					<view class="detail-name" v-if="t.type == 9">财商学院推荐奖励</view>
					
					<view class="detail-text">+{{ t.money / 100 | 0}}</view>
				</view>
				<view class="SN">SN:{{ t.sn }}</view>
				<view class="money">
					<view class="money-text">交易金额(元):{{ t.orderMoney / 100 | 0}}</view>
					<view class="money-time">{{ t.date }}</view>
				</view>
				<view class="across"></view>
				<view style="height:30upx"></view>
			</view>
		</view>

		<view style="height:200upx"></view>
	</view>
</template>

<script>
import net from '../../common/net.js';

export default {
	data() {
		return {
			data:{},
			tabIndex: 0,
			IndexClass: 3,
			useName: [{ name: '全部明细' }, { name: '分润明细' }, { name: '返现明细' }, { name: '其他明细' }]
		};
	},
	
	// 初始化数据
	onLoad(){
		uni.showLoading();
		this.getIncome('all');
	},
	
	
	methods: {
		changTab(index) {
			if (this.tabIndex == index) { return; }
			this.tabIndex = index;
			if(index == 0){
				uni.showLoading();
				this.getIncome('all');
			}
			if(index == 1){
				uni.showLoading();
				this.getIncome('cash');
			}
			if(index == 2){
				uni.showLoading();
				this.getIncome('return');
			}
			if(index == 3){
				uni.showLoading();
				this.getIncome('other');
			}
		},
		
		// 获取政策列表
		getIncome(type){
			net({
	        	url:"/V1/cashs",
	            method:'get',
				data:{ type: type},
	            success: (res) => {
					console.log(res)
					uni.hideLoading();
					if(res.data.error){
						uni.showToast({ title: res.data.error.message, icon: 'none' });
					} else {
						this.data = res.data.success.data;	
					}
	            }
	      	})
		}
	}
};
</script>

<style>
@import 'style/income.css';
</style>
