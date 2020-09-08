<template>
	<view class="body-gy">
		<!-- 头部数据框 -->
		<view class="titlebars">
			<view class="earnings">
				<view class="earning">
					<view class="earning-text">总收益(元)</view>
					<view class="earning-figure">{{ data.revenueAll}}</view>
				</view>
				<view class="across1"></view>
				<view class="button">
					<view class="button-view">
						<view class="button-text">今日收益(元)</view>
						<view class="button-figure">{{ data.revenueDay}}</view>
					</view>
					<view class="button-vertical"></view>
					<view class="button-view">
						<view class="button-text">本月收益(元)</view>
						<view class="button-figure">{{ data.revenueMonth}}</view>
					</view>
				</view>
			</view>
		</view>
		<!-- 选择框 -->
		<view class="dis-fix" style="height: 80rpx;" scroll-with-animation="true">
			<picker class="screen cash-type" mode="selector" :range-key="'name'" :range="useName" @change="changTab">
				<view class="type-title">
					{{ typeName }}
					<image src="../../static/triangle.png" mode="widthFix" class="triangle"></image>
				</view>
			</picker>
			
			<view class="screen cash-data">
				<biaofun-datetime-picker
					placeholder="选择时间"
					start="2019-01"
					end="2100-10"
					fields="month"
					@change="changeDatetimePicker"
				></biaofun-datetime-picker>
				
				<image src="../../static/triangle.png" mode="widthFix" class="triangle"></image>
			</view>
		</view>

		<!-- 内容栏 -->
		<view class="content" v-for="(item, index) in data.cash" :key="index">
			<view class="times">
				<view class="time">{{ item.title }} {{ item.week }}</view>
				<view class="income">收入¥{{ item.money }}</view>
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
					<view class="detail-name" v-if="t.type == 7">达标返现(团队)</view>
					
					
					<image class="detail-img" v-if="t.type == 8" src="/static/sy/fan.png"  />
					<view class="detail-name" v-if="t.type == 8">累计达标返现</view>
					
					<image class="detail-img" v-if="t.type == 9" src="/static/sy/fan.png"  />
					<view class="detail-name" v-if="t.type == 9">累计达标返现(团队)</view>
					
					
					<view class="detail-text">+{{ t.money}}</view>
				</view>
				<view class="SN">SN:{{ t.sn }}</view>
				<view class="money">
					<view class="money-text">交易金额(元):{{ t.orderMoney}}</view>
					<view class="money-time">{{ t.date }}</view>
				</view>
				<view class="across"></view>
				<view style="height:30upx"></view>
			</view>
		</view>

		<view style="height:200upx"></view>
		
		<view class="cu-load load-modal" v-if="loadModal.show">
		   <image src="/static/public/loading.png" mode="aspectFit"></image>
		   <view class="gray-text">{{ loadModal.text }}</view>
		</view>
	</view>
</template>

<script>
import net from '../../common/net.js';
import biaofunDatetimePicker from '@/components/biaofun-datetime-picker/biaofun-datetime-picker.vue';

export default {
	/**
	 * 页面用到的组件
	 */
	components: {
		biaofunDatetimePicker
	},
	data() {
		return {
			loadModal: {
				show: false,
				text: '加载中...'
			},
			data:{
				revenueAll: '0.00',
				revenueDay: '0.00',
				revenueMonth: '0.00',
			},
			tabIndex: 0,
			IndexClass: 3,
			// useName: [{ name: '全部明细' }, { name: '分润明细' }, { name: '返现明细' }, { name: '其他明细' }]
			useName: [
				{ name: '全部明细', type: 'all' },
				{ name: '分润明细', type: 'cash' },
				{ name: '返现明细', type: 'return' },
				{ name: '其他明细', type: 'other' },
			],
			typeName: '全部明细',
			cashType: 'all',
			cashDate: ''
			
		};
	},
	
	// 初始化数据
	onLoad(){
		this.loadModal.show = true;
		this.getIncome();
	},
	
	
	methods: {
		changTab(e) {
			this.typeName = this.useName[e.detail.value].name;
			this.cashType = this.useName[e.detail.value].type;
			
			this.loadModal.show = true;
			this.getIncome();
		},
		
		// 获取政策列表
		getIncome(){
			net({
	        	url:"/V1/cashs",
	            method:'get',
				data:{
					type: this.cashType,
					date: this.cashDate
				},
	            success: (res) => {
					this.loadModal.show = false;
					if(res.data.error){
						uni.showToast({ title: res.data.error.message, icon: 'none' });
					} else {
						this.data = res.data.success.data;
					}
	            }
	      	})
		},
		
		changeDatetimePicker(date) {
			this.loadModal.show = true;
			this.cashDate = date.YYYY + '-' + date.MM;
			this.getIncome();
		},
	}
};
</script>

<style>
@import 'style/income.css';
</style>
