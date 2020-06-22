<template>
	<view>
		<view class="ID">
			<view class="indexs">
				<view class="select">
					<view class="select-view">
						<view class="select-name">姓名：</view>
						<input class="select-text" placeholder="畅伙伴" placeholder-class="place" />
					</view>
					<view class="hengxian"></view>
					<view class="select-view">
						<view class="select-name">预留手机号：</view>
						<input class="select-text" placeholder="15800000000" placeholder-class="place" />
					</view>
					<view class="hengxian"></view>
					<view class="select-view">
						<view class="select-name">结算卡号：</view>
						<input class="select-text" placeholder="6222000000000000000" placeholder-class="place" />
					</view>
					<view class="hengxian"></view>
					<view class="select-view">
						<view class="select-name">结算银行：</view>
						<input class="select-text" placeholder="工商银行" placeholder-class="place" />
					</view>
					<view class="hengxian"></view>
					<view class="select-view">
						<view class="select-name">支行名称：</view>
						<input class="select-text" placeholder="工商银行济南分行" placeholder-class="place" />
					</view>
					<view class="hengxian"></view>
					<view class="select-view1">
						<view class="select-name">所在地区：</view>
						<view class="tab select-text1" @tap="toggleTab('region')">{{ resultInfo.result }}</view>
						<w-picker
							mode="region"
							:defaultVal="regionDval"
							:areaCode="['11', '1101', '110101']"
							:hideArea="false"
							@confirm="onConfirm"
							ref="region"
							:timeout="true"
						></w-picker>
					</view>
				</view>
			</view>
		 </view>
		<view class="picture">
			<view class="photograph">
				<image class="photograph-image" src="/static/shuzi/bank_card.jpg" />
				<image class="photograph-image" src="/static/shuzi/bank_card2.jpg" />
			</view>
		</view>
	    <view><button>确 认 修 改</button></view>
	</view>
</template>

<script>
import wPicker from '@/components/w-picker/w-picker.vue';

export default {
	components: {
		wPicker
	},
	data() {
		return {
			title: 'Hello',
			startYear: new Date().getFullYear(),
			regionDval: ['北京市', '市辖区', '东城区'],
			resultInfo: {
				result: '请选择所在地区'
			}
		};
	},
	computed: {},
	mounted() {},
	methods: {
		toggleTab(str) {
			this.$refs[str].show();
		},
		onConfirm(val) {
			console.log(val);
			this.resultInfo = { ...val };
		}
	}
};
</script>

<style>
.indexs {
	width: 100%;
	background-color: #fff;
	margin-top: 20rpx;
	border-radius: 10rpx 10rpx 10rpx 10rpx;
}

.selects {
	width: 100%;
	position: relative;
	margin-top: 2%;
}

.select-view {
	display: flex;
	height: 100rpx;
}
.select-view1 {
	display: flex;
	height: 100rpx;
	position: relative;
}

.select-name {
	margin-left: 40rpx;
	margin-top: 4.5%;
	font-size: 25rpx;
	width: 26%;
}
.select-text {
	margin-top: 4.5%;
	font-size: 25rpx;
	color: #666;
	width: 70%;
}
.select-text1 {
	position: absolute;
	top: 35upx;
	left: 235upx;
	font-size: 25rpx;
	color: #666;
}

.hengxian {
	width: 94%;
	height: 1px;
	background-color: #dbdada;
	margin-left: 3%;
}
.ckeck {
	width: 90%;
	margin-left: 5%;
	font-size: 28rpx;
	margin-top: 3%;
}
button {
	width: 80%;
	margin-top: 50rpx;
	background: linear-gradient(to right, #fe695a, #f64547);
	color: #fff;
}
/*  */
.picture {
	height: 100%;
	background-color: #fff;
	border-radius: 4px 4px 4px 4px;
	box-shadow: #ddd 3px 3px 8px 3px;
	overflow: hidden;
	margin-top: 2%;
}

.photograph {
	height: 6.5rem;
	margin-top: 2%;
}
.photograph-image {
	width: 40%;
	height: 5rem;
	margin-left: 6%;
	box-shadow: #d3d3d3 0 0 4px 0;
	margin-top: 3%;
}
</style>