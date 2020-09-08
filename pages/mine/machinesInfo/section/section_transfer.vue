<template>
	<view>
		<!-- 选择SN号 -->
		<view class="start-over">
			<view class="select">
				<text class="select-name">机具起始SN：</text>
				<input type="text" class="sn-input" placeholder="请输入起始SN号" v-model="startSn">
			</view>
			<view class="select-xian"></view>
			<view class="select">
				<text class="select-name">机具结束SN：</text>
				<input type="text" class="sn-input" value="" placeholder="请输入结束SN号" v-model="endSn"/>
			</view>
			<view class="select-xian"></view>
			<view class="hint">提示:区间划拨可能存在序列号间断，或已激活</view>
			<view class="select-button" @click="getSectionMachines">查 询</view>
		</view>
		<!-- sn号显示 -->
		<view class="show">
			<checkbox-group @change="optTerminal">
				<view v-for="(item, index) in show" :key="index">
					<view class="checkbox-view">
						<text class="checkbox-text">SN：{{item.sn}}</text>
						<checkbox class="checkbox" :value="item.id" checked=true color="#f98021"></checkbox>
					</view>
					<view class="xian"></view>
				</view>
			</checkbox-group>
		</view>
		<view style="height: 100upx"></view>
		<view class="button" @click="transfer">确 认 选 择<text>（{{ transferNum }}）</text></view>
		
		<view class="cu-load load-modal" v-if="loadModal.show">
		   <image src="/static/public/loading.png" mode="aspectFit"></image>
		   <view class="gray-text">{{ loadModal.text }}</view>
		</view>
	</view>
</template>

<script>
import net from '../../../../common/net.js';

export default {

	data() {
		return {
			loadModal: {
				show: false,
				text: '加载中...'
			},
			// 被划拨人id
			partnerId: '',
			// 政策id
			policyId: '',
			// 划拨机器列表
			termIds: [],
			
			startSn:'',
			endSn:'',
			transferNum: 0,
			show: {}
		};
	},
	onLoad(options) {
		this.partnerId = options.uid;
		this.policyId = options.policy_id;
	},
	methods: {
		
		// 获取可划拨终端列表
		getSectionMachines(){
			
			if (this.policyId == '' || this.policyId == undefined) {
				uni.showToast({ title: '请选择划拨政策', icon: 'none', position: 'bottom' });
				return false;
			}
			
			if (this.partnerId == '' || this.partnerId == undefined) {
				uni.showToast({ title: '请选择划拨用户', icon: 'none', position: 'bottom' });
				return false;
			}
			
			if (this.startSn == '' || this.startSn == undefined) {
				uni.showToast({ title: '请输入起始SN号', icon: 'none', position: 'bottom' });
				return false;
			}
			
			if (this.startSn == '' || this.startSn == undefined) {
				uni.showToast({ title: '请输入结束SN号', icon: 'none', position: 'bottom' });
				return false;
			}
			
			this.loadModal = {
				show: true,
				text: '查询中...'
			};
			net({
	        	url:"/V1/sectionPolicy",
	            method: 'GET',
				data: {
					policy_id: this.policyId,
					begin_sn: this.startSn,
					end_sn: this.endSn,
				},
	            success: (res) => {
					console.log(res);
					this.loadModal.show = false;
					if (res.data.success) {
						this.show = res.data.success.data;
						this.transferNum = this.show.length;	// 选中数量，默认全选
						
						let that = this;
						this.show.forEach((item, index) => {
							that.termIds[index] = item.id
						});
					} else {
						uni.showToast({
							title: res.data.error.message,
							icon: 'none',
							position: 'bottom'
						})
					}
	            }
	      	})
		},
		
		// 选择终端
		optTerminal(e){
			this.termIds = e.target.value;
			this.transferNum = e.detail.value.length;
		},
		
		transfer(){
			this.loadModal = {
				show: true,
				text: '划拨中...'
			};
			
			net({
	        	url:"/V1/addTransfer",
	            method: 'POST',
				data: {
					id: this.termIds,
					friend_id: this.partnerId
				},
	            success: (res) => {
					this.loadModal.show = false;
					
					var _this = this;
					if (res.data.success) {
						uni.showToast({
							title: '划拨成功',
							icon: 'none'
						})
						setTimeout(function() {
							uni.redirectTo({
								url: 'section_transfer?policy_id=' + _this.policyId + '&uid=' + _this.partnerId
							});
						}, 1500);
					} else {
						uni.showToast({
							title: res.data.error.message,
							icon: 'none'
						})
					}
	            }
	      	})
		}
	}
};
</script>

<style> 
	@import url("../../style/machine_section");
</style>
