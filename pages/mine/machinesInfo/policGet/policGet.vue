<template>
	<view>
		<view class="view"  >
			<view v-for="(item,index) in policy" :key="index" @click="optPolicy(item)">
				<view class="policy">
					<view class="model">
						<text class="model-text">{{item.title}}</text>
					</view>
					<!-- <view class="amount"></view> -->
					<image class="model-image" src="/static/jiantou.png" mode="widthFix"></image>
				</view>
				<view class="xian"></view>
			</view>
		</view>
	</view>
</template>

<script>
import net from '../../../../common/net.js';
export default {
	data() {
		return {
			// policy:[
			// 	{
			// 		name:"MP70",
			// 		text:'-99返150(线下普通版)',
			// 		amount:'500台'
			// 	}
			// ]
			policy: []
		};
	},
	
	onLoad() {
		this.getPolicyList();
	},
	methods: {
		// 获取政策信息
		getPolicyList(){
			net({
	        	url:"/V1/getPolicy",
	            method: 'get',
	            success: (res) => {
					console.log(res);
					this.policy = res.data.success.data;
	            }
	      	})
		},
		
		// 选择政策并跳转
		optPolicy(item) {
			var pages = getCurrentPages();
			var prevPage = pages[pages.length - 2]; //上一个页面
			
			var data = {
				id : item.id,
				title : item.title,
			};
			prevPage.$vm.policyInfo = data;
			uni.navigateBack();
		}
	}
};
</script>

<style>
@import url("../../style/policy_opt.css");
</style>
