<template>
	<view v-if="merchantData != ''">
		<view class="class">
			<navigator url="jijuchakan/jijuchakan?type=count" class="class-view">
				<view class="class-text">机具总数(台):</view>
				<view class="class-figure">{{merchantData.count.all}}</view>
				<view class="chakan">查 看 ></view>
			</navigator>
			<view class="hengxian"></view>
			<view class="class-view2">
				<view class="view-text">
					<view class="text">未绑定</view>
					<view class="figure">{{merchantData.count.NoMerchant}}</view>
				</view>
				<view class="shuxian"></view>
				<view class="view-text">
					<view class="text">已绑定</view>
					<view class="figure">{{merchantData.count.Merchant}}</view>
				</view>
				<view class="shuxian"></view>
				<view class="view-text">
					<view class="text">已激活</view>
					<view class="figure">{{merchantData.count.Merchant_status}}</view>
				</view>
				<view class="shuxian"></view>
				<view class="view-text">
					<view class="text">已达标</view>
					<view class="figure">{{merchantData.count.standard_statis}}</view>
				</view>
			</view>
		</view>
		<view class="class">
			<navigator url="jijuchakan/jijuchakan?type=user" class="class-view">
				<view class="class-text">我的机具(台):</view>
				<view class="class-figure">{{merchantData.user.all}}</view>
				<view class="chakan">查 看 ></view>
			</navigator>
			<view class="hengxian"></view>
			<view class="class-view2">
				<view class="view-text">
					<view class="text">未绑定</view>
					<view class="figure">{{merchantData.user.NoMerchant}}</view>
				</view>
				<view class="shuxian"></view>
				<view class="view-text">
					<view class="text">已绑定</view>
					<view class="figure">{{merchantData.user.Merchant}}</view>
				</view>
				<view class="shuxian"></view>
				<view class="view-text">
					<view class="text">已激活</view>
					<view class="figure">{{merchantData.user.Merchant_status}}</view>
				</view>
				<view class="shuxian"></view>
				<view class="view-text">
					<view class="text">已达标</view>
					<view class="figure">{{merchantData.user.standard_statis}}</view>
				</view>
			</view>
		</view>
		
		<view class="class">
			<navigator url="jijuchakan/jijuchakan?type=friend" class="class-view">
				<view class="class-text">伙伴机具(台):</view>
				<view class="class-figure">{{merchantData.friend.all}}</view>
				<view class="chakan">查 看 ></view>
			</navigator>
			<view class="hengxian"></view>
			<view class="class-view2">
				<view class="view-text">
					<view class="text">未绑定</view>
					<view class="figure">{{merchantData.friend.NoMerchant}}</view>
				</view>
				<view class="shuxian"></view>
				<view class="view-text">
					<view class="text">已绑定</view>
					<view class="figure">{{merchantData.friend.Merchant}}</view>
				</view>
				<view class="shuxian"></view>
				<view class="view-text">
					<view class="text">已激活</view>
					<view class="figure">{{merchantData.friend.Merchant_status}}</view>
				</view>
				<view class="shuxian"></view>
				<view class="view-text">
					<view class="text">已达标</view>
					<view class="figure">{{merchantData.friend.standard_statis}}</view>
				</view>
			</view>
		</view>
		<view class="class-view3">
			<view class="view-text">
				<navigator url="jijuhuabo/jijuhuabo">
					<image src="../../../static/jjhb.png" class="image"></image>
					<view class="figure">机具划拨</view>
				</navigator>
			</view>

			<view class="shuxian1"></view>
			<view class="view-text">
				<navigator url="jijuhuabo/call_back">
					<image src="../../../static/jjhuib.png" class="image"></image>
					<view class="figure">机具回拨</view>
				</navigator>
			</view>
			<view class="shuxian1"></view>
			<view class="view-text">
				<navigator url="huabojilu/huabojilu">
					<image src="../../../static/hbjl.png" class="image"></image>
					<view class="figure">调拨记录</view>
				</navigator>
			</view>
			<!-- <view class="shuxian1"></view>
			<view class="view-text">
				<navigator url="zhongduandingjia/zhongduandingjia">
					<image src="../../../static/zddj.png" class="image"></image>
					<view class="figure">终端定价</view>
				</navigator>
			</view> -->
		</view>
	</view>
</template>

<script>
import net from '../../../common/net.js';

export default {
	data() {
		return {
			merchantData: []
		};
	},
	
	onShow() {
		// 获取机器数据
		this.getMerchantData();
		uni.showLoading();
	},
	
	methods: {
		// 获取机器数据
		getMerchantData(){
			net({
				url: '/V1/getBindAll',
				method: 'GET',
				success: (res) => {
					uni.hideLoading();
					if (res.data.success) {
						this.merchantData = res.data.success.data;
					} else {
						uni.showToast({
							title: res.data.error.message,
							icon: 'none'
						})
					}
					console.log(res);
				}
			})
		}
	}
};
</script>

<style>
@import url("../style/merchant.css");
</style>
z