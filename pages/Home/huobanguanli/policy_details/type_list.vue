<template>
	<view class="backgroundColor">
		<navigator  hover-class="none"  class="data-list" :url="'./share_profit?uid=' + uid + '&gid=' + gid">
			<view class="data">
				<view class="phone">分润参数</view>
				<view class="mark">设置</view>
			</view>
		</navigator>
		<navigator  hover-class="none"  class="data-list" :url="'./policy_details?uid=' + uid + '&gid=' + gid">
			<view class="data">
				<view class="phone">返现参数</view>
				<view class="mark">设置</view>
			</view>
		</navigator>
	</view>
</template>

<script>
import net from '../../../../common/net.js';

export default {
	data() {
		return {
			uid: '',
			gid: '',
		};
	},
	
	onLoad(options) {
		this.uid = options.uid;
		this.gid = options.gid;
	},
	
	methods: {
		
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
