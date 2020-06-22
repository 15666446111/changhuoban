<template>
	<view>
		<view class="sousuo">
			<view class="sousuo-view">
				<image class="input-image" src="/static/left_fdj.png" mode="aspectFit"></image>
				<input class="input" placeholder="请正确输入有效SN号" />
			</view>
		</view>
		<view class="view">
			<checkbox-group @change="optTerminal">
				<view v-for="(item, index) in policy" :key="index">
					<view class="checkbox-view">
						<text class="checkbox-text">SN：{{item.merchant_sn}}</text>
						<checkbox class="checkbox" :value="item.id" color="#f98021"></checkbox>
					</view>
					<view class="xian"></view>
				</view>
			</checkbox-group>
		</view>
		
		<view style="height: 100upx"></view>
		<view class="button" @click="transfer">确 认 回 拨<text>({{tranNum}})</text></view>
	</view>
</template>

<script>
import net from '../../../../common/net.js';

export default {
	data() {
		return {
			// 被回拨人id
			partnerId: '',
			// 政策id
			policyId: '',
			// 终端列表
			policy: {},
			termIds: [],
			// 划拨数量
			tranNum: 0,
		};
	},
	onLoad(options) {
		this.partnerId = options.uid;
		this.policyId = options.policy_id;
		// 获取可回拨终端列表
		this.getBackList(this.policyId);
		console.log(options);
	},
	
	methods: {
		// 获取可回拨终端列表
		getBackList(policyId){
			net({
	        	url:"/V1/getBackList",
	            method: 'get',
				data: {
					policy_id: policyId,
					friend_id: this.partnerId,
					
				},
	            success: (res) => {
					this.policy = res.data.success.data;
	            }
	      	})
		},
		
		// 选择终端
		optTerminal(e){
			// console.log(e.target.value.length);
			this.termIds = e.target.value;
			this.tranNum = e.target.value.length;
		},
		
		// 回拨
		transfer(){
			if (this.termIds == '') {
				uni.showToast({ title: '请选择回拨终端', icon: 'none' })
				return false;
			}
			if (this.partnerId == '') {
				uni.showToast({ title: '请选择回拨用户', icon: 'none' })
				return false;
			}
			var friend_id = [this.partnerId];
			net({
	        	url:"/V1/addBackTransfer",
	            method: 'POST',
				data: {
					merchant_id: this.termIds,
					friend_id: friend_id
				},
	            success: (res) => {
		
					var _this = this;
					if (res.data.success) {
						uni.showToast({
							title: '回拨成功',
							icon: 'none',
						})
						setTimeout(function() {
							uni.redirectTo({
								url: './opt_call_back?policy_id=' + _this.policyId + '&uid=' + _this.partnerId
							});
						}, 1500)
					}
	            }
	      	})
		}
	}
};
</script>

<style>
/* 搜索框 */
.sousuo {
	width: 90%;
	margin-left: 5%;
	background-color: #fff;
	border-radius: 15upx 15upx 15upx 15upx;
	box-shadow: #d9d9d9 0 0 4px 0;
	margin-top: 2%;
}
.sousuo-view {
	width: 100%;
	display: flex;
	margin-left: 3%;
}
.input-image {
	width: 60upx;
	height: 60upx;
	margin-top: 10upx;
}
.input {
	border: 0;
	width: 88%;
	height: 80upx;
}

/* 内容 */
.view {
	width: 92%;
	height: 100%;
	margin-left: 4%;
	background-color: #ffffff;
	margin-top: 2%;
}

.checkbox-view {
	width: 100%;
	height: 90upx;
	line-height: 90upx;
	border-radius: 15upx 15upx 15upx 15upx;
	position: relative;
}
.checkbox-text {
	margin-left: 5%;
	font-size: 31upx;
	color: #333;
}
.checkbox {
	position: absolute;
	right: 5%;	
}
.xian{
	width: 96%;
	margin-left: 2%;
	height: 1upx;
	background-color: #F1F1F1; 
} 
.button{
	position: fixed;
	width: 100%;
	background-color: #ff8c00;
	bottom: 0px;
	height: 90upx;
	text-align: center;
	line-height: 90upx;
	color: #fff;
	font-size: 35upx;
}
</style>