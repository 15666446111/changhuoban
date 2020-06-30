<template>
	<view>
		<view class="sousuo">
			<view class="sousuo-view">
				<image class="input-image" src="/static/left_fdj.png" mode="aspectFit"></image>
				<input class="input" placeholder="请输入机器SN号" />
			</view>
		</view>
		<radio-group @change="getTermNum">
			<view class="view">
				<label class="term-info" v-for="(item, index) in termList" :key="index">
					<view class="checkbox-view">
						<text class="checkbox-text">SN：{{ item.merchant_sn }}</text>
						<radio class="checkbox" color="#f98021" v-model="item.merchant_sn" />
					</view>
					<view class="xian"></view>
				</label>
			</view>
		</radio-group>
		
		<button class="term-define" @click="define">确定</button>
		
		<view class="public-empty-tips" v-if="termList == ''">没有需要登记的终端信息~</view>
	</view>
</template>

<script>
import net from '../../../../common/net.js';

export default {
	data() {
		return {
			// 机器列表
			termList: [],
			// 终端号
			merchant_sn: '',
		};
	},
	
	onLoad() {
		uni.showLoading();
		
		// 获取终端信息
		this.getTermList();
	},
	
	methods: {
		// 获取终端信息
		getTermList(){
			net({
	        	url:"/V1/getNoBindMerchant",
	            method:'get',
	            success: (res) => {
					uni.hideLoading();
					this.termList = res.data.success.data;
	            }
	      	})
		},
		
		// 获取radio选中的值
		getTermNum(e){
			this.merchant_sn = e.detail.value;
		},
		
		define(){
			var pages = getCurrentPages();
			var prevPage = pages[pages.length - 2]; //上一个页面
			
			prevPage.$vm.merchant_sn = this.merchant_sn;
			uni.navigateBack();
			// uni.redirectTo({
			// 	url: "../shanghudengji?terminal=" + this.terminal
			// })
		}
		
		
	}
};
</script>

<style>
@import url("../../style/term_opt.css");
</style>
