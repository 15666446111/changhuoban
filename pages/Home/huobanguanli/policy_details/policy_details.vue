<template>
	<view class="backgroundColor">
		<view class="data"><view class="phone">我的活动：</view></view>
		<view class="dara-xian"></view>
		<navigator  hover-class="none"  class="data-list" :url="'./return_cash?pid=' + item.id + '&uid=' + uid" v-for="(item, index) in policyList" :key="index">
			<view class="data">
				<view class="phone">{{item.title}}</view>
				<view class="mark">查看</view>
			</view>
		</navigator>
		<view v-if="policyList == undefined" style="padding-top: 50rpx; color:#999; text-align: center;">
			—— 暂无活动信息 ——
		</view>
	</view>
</template>

<script>
import net from '../../../../common/net.js';

export default {
	data() {
		return {
			uid: '',
			gid: '',
			policyList: [],
			type: ''
		};
	},
	
	onLoad(options) {
		this.uid = options.uid;
		this.gid = options.gid;
		this.getPolicyList();
	},
	
	methods: {
		// 获取政策列表
		getPolicyList(){
			net({
	        	url:"/V1/userPolicy",
	            method:'get',
				data: {
					uid: this.uid,
					gid: this.gid,
				},
				success: (res) => {
					console.log(res);
					if (res.data.success) {
						this.policyList = res.data.success.data;
					} else {
						
					}
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
	/* box-shadow: #d9d9d9 0 0 4px 0; */
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
