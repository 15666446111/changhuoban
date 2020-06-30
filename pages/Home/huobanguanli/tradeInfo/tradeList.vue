<template>
	<view>
		<view class="particulars">
			<!-- 选择栏 -->
			<view class="select">
				<view class="select-view row" v-for="(item, index) in select" :key="index" @tap="changecate(index)">
					<view class="select-text" :class="activeInde === index ? 'select-text2' : ''">{{ item.name }}</view>
				</view>
			</view>

			<view class="performance d-flex" style="margin-top: 2%;">
				
				<view class="vertical"></view>
				
				

				<!-- 数据 -->
				<view class="datas">
					<view class="times">
						<view class="shu"></view>
						<view class="time">{{ datalist.date }}</view>
					</view>
					
					<view class="data">
						
						<view class="data-s">
							<view class="deal">今日交易</view>
							<view class="money">{{ datalist.trade }}</view>
							<image class="image" src="/static/jiantou.png" mode="aspectFit" />
						</view>
						
						<view class="hengxian"></view>
					</view>

					<view class="data">
						
						<view class="data-s">
							<view class="deal">激活总数</view>
							<view class="money">{{ datalist.activeCount }}</view>
							<image class="image" src="/static/jiantou.png" mode="aspectFit" />
						</view>
						
						<view class="hengxian"></view>
					</view>		

					<view class="data">
						
						<view class="data-s">
							<view class="deal">机具总数</view>
							<view class="money">{{ datalist.merchants }}</view>
							<image class="image" src="/static/jiantou.png" mode="aspectFit" />
						</view>
						
						<view class="hengxian"></view>
					</view>					

					<view class="data">
						
						<view class="data-s">
							<view class="deal">收益总数</view>
							<view class="money">{{ datalist.income }}</view>
							<image class="image" src="/static/jiantou.png" mode="aspectFit" />
						</view>
						
						<view class="hengxian"></view>
					</view>	

					<view class="data">
						
						<view class="data-s">
							<view class="deal">伙伴总数</view>
							<view class="money">{{ datalist.friends }}</view>
							<image class="image" src="/static/jiantou.png" mode="aspectFit" />
						</view>
						
						<view class="hengxian"></view>
					</view>	

					<view class="data">
						
						<view class="data-s">
							<view class="deal">商户总数</view>
							<view class="money">{{ datalist.merchants }}</view>
							<image class="image" src="/static/jiantou.png" mode="aspectFit" />
						</view>
						
						<view class="hengxian"></view>
					</view>

					<view class="data">
						<view class="data-s">
							<view class="deal">台均交易量</view>
							<view class="money">{{ datalist.Avg }}</view>
							<image class="image" src="/static/jiantou.png" mode="aspectFit" />
						</view>
						<view class="hengxian"></view>
					</view>


				</view>
				
				
			
			</view>
		</view>
	</view>
</template>

<script>
	
import net from '../../../../common/net.js';

export default {
	data() {
		return {
			activeInde: 0,
			activeIndex: 0,
			uid: 0,
			select: [{ name: '按日查询' }, { name: '按月查询' }],
			
			datalist:[],
		};
	},

	onLoad: function (options){
		this.uid = options.uid;
		if(!this.uid){
			alert('参数错误');
		}
		
		this.getTeamDetail(this.uid, 'day');
	},
	
	
	methods: {
		changeCate(index) {
			this.activeIndex = index;
		},
		changecate(index) {
			// 按月查询 按日查询
			if( this.activeInde !== index){
				if(index == 0){
					this.getTeamDetail(this.uid, 'day');
				}
				if(index == 1){
					this.getTeamDetail(this.uid, 'month');
				}
				this.activeInde = index;
			}
		},
		
		/**
		 * 获取详情
		 */
		getTeamDetail(uid, type){
	    	net({
	        	url:"/V1/getTradeDetail",
	            method:'post',
				data:{
					data_type: type,
					uid: uid
				},
	            success: (res) => {
					uni.hideLoading();
					console.log(res)
					if(res.data.success){
						this.datalist = res.data.success.data;
					}
					
					if(res.data.error){
						
					}
	            }
	      	})
		}
	}
};
</script>

<style>
/* 顶部选择 */
.select {
	width: 100%;
	height: 100upx;
	display: flex;
	background-color: #fff;
}
.select-view {
	width: 50%;
	justify-content: center;
}
.select-text {
	width: 50%;
	height: 100upx;
	line-height: 100upx;
	text-align: center;
	font-size: 30upx;
}
.select-text2 {
	width: 50%;
	height: 100upx;
	line-height: 100upx;
	color: #f98021;
	border-bottom: 3upx solid #f98021;
	text-align: center;
	font-size: 30upx;
}
/* 详情栏 */

/* 代理 */
.agency {
	width: 25.5%;
	background-color: #fff;
}
.agency-view {
	text-align: center;
	width: 100%;
}
.agency-text {
	height: 100upx;
	line-height: 100upx;
	font-size: 30upx;
}
.agency-text2 {
	height: 100upx;
	line-height: 100upx;
	background-color: #f98021;
	color: #ffffff;
	font-size: 30upx;
}
.agency-xian {
	width: 100%;
	height: 1upx;
	background-color: #f2f2f2;
}
.vertical {
	width: 0.5%;
	height: 100%;
}
/* 数据 */
.datas {
	width: 98%;
	margin-left: 1%;
	background-color: #fff;
}
.times {
	width: 100%;
	height: 80upx;
	display: flex;
	background-color: #f2f2f2;
}

.time {
	font-size: 0.9rem;
	margin-top: 0.2rem;
	margin-left: 0.4rem;
}
.shu {
  width: 1%;
  height: 30rpx;
  background-color: #FF8C00;
  margin: 18rpx 20rpx;
}


.data {
	width: 100%;
}


.data-s {
	height: 100upx;
	display: flex;
	width: 100%;
	position: relative;
	font-size: 28upx;
}

.image {
	width: 30upx;
	height: 30upx;
	position: absolute;
	right: 20upx;
	top: 35upx;
}
.deal {
	margin-left: 3%;
	height: 100upx;
	line-height: 100upx;
	font-size: 30upx;
}
.money {
	position: absolute;
	right: 2rem;
	color: #f98021;
	height: 100upx;
	line-height: 100upx;
	font-size: 30upx;
}

.hengxian {
	width: 100%;
	height: 1px;
	background-color: #e6e6e6;
}
</style>
