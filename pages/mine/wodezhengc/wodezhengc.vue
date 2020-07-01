<template>
	<view class="backgroundColor"v-if="operate!==3">
		<view class="data"><view class="phone">我的政策：</view></view>
		<view class="dara-xian"></view>
		<navigator class="data-list" :url="'zhengceyemian/zhengceyemian?pid=' + item.id + '&uid=' + uid" v-for="(item, index) in policyList" :key="index">
			<view class="data">
				<view class="phone">{{item.title}}</view>
				<view class="mark">查看</view>
			</view>
		</navigator>
	</view>
</template>

<script>
import net from '../../../common/net.js';

export default {
	data() {
		return {
			uid: '',
			policyList: [],
			operate: ''
		};
	},
	
	onLoad(options) {
		this.operate 	= uni.getStorageSync('operate');
		this.uid = options.uid;
		uni.showLoading();
		this.getPolicyList();
	},
	
	methods: {
		// 获取政策列表
		getPolicyList(){
			net({
	        	url:"/V1/getPolicy",
	            method:'get',
	            success: (res) => {
					uni.hideLoading();
					
					this.policyList = res.data.success.data;
	            }
	      	})
		}
	}
};
</script>

<style>
/*内容栏*/

.backgroundColor {
	width: 100%;
	margin-top: 3%;
	border-radius: 0.2rem 0.2rem 0.2rem 0.2rem;
	box-shadow: #d9d9d9 0 0 4px 0;
}
.data {
	display: flex;
	background-color: #fff;
	height: 100upx;
	position: relative;
}

.mark {
	position: absolute;
	color: #ed6e11;
	right: 6%;
	top: 25%;
	font-size: 28upx;
}
.phone {
	margin-top: 3.5%;
	margin-left: 5%;
	font-size: 28upx;
}
.dara-xian {
	width: 94%;
	height: 1px;
	margin-left: 3%;
	background-color: #f1f1f1;
}
.data-list {
	border-bottom: 1px solid #f1f1f1;
}
</style>
