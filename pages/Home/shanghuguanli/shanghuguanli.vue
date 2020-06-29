<template>
	<view>
		<!-- 搜索框 -->
		<view class="sousuo">
			<view class="sousuo-view">
				<image class="input-image" src="/static/left_fdj.png" mode="aspectFit"></image>
				<input class="input" placeholder="SN/姓名/手机号/商户号" />
			</view>
		</view>
		
		<!-- 选择框2 -->
		<view class="dis-fix" style="height: 80rpx;" scroll-with-animation="true">	
			<view
				class="dis-div"
				@click="HeadTab(index)"
				style="height: 80rpx; line-height: 80rpx;"
				v-for="(item, index) in head" :key="index"
				:class="Head === index ? 'usename' : ''"
				:id="'tab' + index">
				<text class="dis-text">{{ item.name }}</text>
				<text :class="index < HeadClass ? 'shuxian1' : ''"></text>
			</view>
		</view>
		
		<view class="content">
			<!-- 已绑定商户 -->
			<navigator v-if="Head == 0" v-for="(item, index) in bindList" :key="index" :url="'shanghuxinxi/shanghuxinxi?id=' + item.machine_id">
				<view id="view">
					<view class="detail">
						<view class="detail-name">{{ item.merchant_name }}</view>
						<view class="detail-text1">累计交易:</view>
						<view class="detail-text">{{ item.money > 0 ? item.money / 100 : 0 }}</view>
					</view>
					<view class="SN">SN:{{ item.merchant_sn }}</view>

					<view class="money">
						<view class="money-text">商户号:{{ item.merchant_number }}</view>
						<view class="money-time">登记时间：{{ item.created_at }}</view>
					</view>
				</view>
				<view class="across"></view>
			</navigator>
			
			<!-- 未绑定商户 -->
			<navigator v-if="Head == 1" v-for="(item, index) in unBindList" :key="index" :url="'shanghuxinxi/shanghuxinxi'">
				<view id="view">
					<view class="detail">
						<view class="detail-name">{{ item.merchant_name }}</view>
						<view class="detail-text1">累计交易:</view>
						<view class="detail-text">{{ item.amount }}</view>
					</view>
					<view class="SN">SN:{{ item.merchant_sn }}</view>

					<view class="money">
						<view class="money-text">商户号:{{ item.merchant_number }}</view>
						<view class="money-time">登记时间：{{ item.created_at }}</view>
					</view>
				</view>
				<view class="across"></view>
			</navigator>
		</view>
		
		<view class="public-empty-tips" v-if="BindTips">
			没有已绑定的商户信息~
		</view>
		<view class="public-empty-tips" v-if="unBindTips">
			没有未绑定的商户信息~
		</view>
	</view>
</template>

<script>
import net from '../../../common/net.js';
export default {
	data() {
		return {
			tabIndex: 0,
			HeadClass: 1,
			Head:0,
			head: [{ name: '已绑定' }, { name: '未绑定' }],
			
			// 已绑定商户列表
			bindList: [],
			// 未绑定商户列表
			unBindList: [],
			// 商户是否为空状态
			BindTips: false,
			unBindTips: false,
		};
	},
	
	onLoad() {
		// 获取商户列表
		this.getMerchantsList();
		uni.showLoading();
	},
	
	methods: {
		HeadTab(index) {
			if (this.Head == index) {
				return;
			}
			this.Head = index;
			
			// 信息为空时，显示提示信息
			this.BindTips = (this.Head == 0 && this.bindList == '');
			this.unBindTips = (this.Head == 1 && this.unBindList == '');
		},
		
		// 获取商户列表
		getMerchantsList(){
			net({
				url: '/V1/getMerchantsList',
				method: 'GET',
				success: (res) => {
					console.log(res);
					uni.hideLoading();
					// console.log(res);
					this.bindList = res.data.success.data.Bound;
					this.unBindList = res.data.success.data.UnBound;
				}
			})
		}
	}
};
</script>

<style>
@import url("../style/merchant_list.css");
</style>

