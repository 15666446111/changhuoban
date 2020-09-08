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
						<view class="time" v-if="activeInde == 0">{{ datalist.date }}</view>
						<view class="time" v-if="activeInde == 1">
							<biaofun-datetime-picker
								placeholder="选择时间"
								:defaultValue="datalist.date"
								start="2019-01"
								end="2100-10"
								fields="month"
								@change="changeDatetimePicker"
							>
							</biaofun-datetime-picker>
							<image src="../../../../static/calendar.png" class="calendar-img" mode="widthFix" style="width: 56rpx;"></image>
						</view>
					</view>
					
					<view class="data">
						
						<view class="data-s" @click="getDetails('../../../tuandui/data_details/trade')">
							<view class="deal">交易金额</view>
							<view class="money">{{ datalist.trade }}</view>
							<image class="image" src="/static/jiantou.png" mode="aspectFit" />
						</view>
						
						<view class="hengxian"></view>
					</view>

					<view class="data">
						
						<view class="data-s" @click="getDetails('../../../tuandui/data_details/active')">
							<view class="deal">激活总数</view>
							<view class="money">{{ datalist.activeCount }}</view>
							<image class="image" src="/static/jiantou.png" mode="aspectFit" />
						</view>
						
						<view class="hengxian"></view>
					</view>		

					<view class="data">
						
						<view class="data-s" @click="getDetails('../../../tuandui/data_details/temail')">
							<view class="deal">机具总数</view>
							<view class="money">{{ datalist.temails }}</view>
							<image class="image" src="/static/jiantou.png" mode="aspectFit" />
						</view>
						
						<view class="hengxian"></view>
					</view>					

					<view class="data">
						
						<view class="data-s" @click="getDetails('../../../tuandui/data_details/profit')">
							<view class="deal">收益总数</view>
							<view class="money">{{ datalist.income }}</view>
							<image class="image" src="/static/jiantou.png" mode="aspectFit" />
						</view>
						
						<view class="hengxian"></view>
					</view>	

					<view class="data">
						
						<view class="data-s" @click="getDetails('../../../tuandui/data_details/team_user')">
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

					<view class="data" v-if="activeInde == 1">
						<view class="data-s" @click="getDetails('../../../tuandui/data_details/average_trade')">
							<view class="deal">台均交易量</view>
							<view class="money">{{ datalist.Avg }}</view>
							<image class="image" src="/static/jiantou.png" mode="aspectFit" />
						</view>
						<view class="hengxian"></view>
					</view>
					
				</view>
			</view>
		</view>
		
		<view class="cu-load load-modal" v-if="loadModal.show">
		   <image src="/static/public/loading.png" mode="aspectFit"></image>
		   <view class="gray-text">{{ loadModal.text }}</view>
		</view>
	</view>
</template>

<script>
	
import net from '../../../../common/net.js';
import biaofunDatetimePicker from '@/components/biaofun-datetime-picker/biaofun-datetime-picker.vue';

export default {
	components: {
		biaofunDatetimePicker
	},
	data() {
		return {
			loadModal: {
				show: false,
				text: '加载中...'
			},
			activeInde: 0,
			activeIndex: 0,
			uid: 0,
			select: [{ name: '按日查询' }, { name: '按月查询' }],
			
			datalist:[],
			date: ''
		};
	},

	onLoad: function (options){
		this.uid = options.uid;
		if(!this.uid){
			alert('参数错误');
		}
		
		this.loadModal.show = true;
		this.getTeamDetail();
	},
	
	
	methods: {
		changeCate(index) {
			this.activeIndex = index;
		},
		changecate(index) {
			// 按月查询 按日查询
			if( this.activeInde !== index){
				this.activeInde = index;
				
				this.loadModal.show = true;
				this.getTeamDetail();
			}
		},
		
		/**
		 * 获取详情
		 */
		getTeamDetail(){
			let dataType = this.activeInde == 0 ? 'day' : 'month';
			
			console.log(dataType);
	    	net({
	        	url:"/V1/getTradeDetail",
	            method:'post',
				data:{
					current: 'team',
					data_type: dataType,
					uid: this.uid,
					date: this.date
				},
	            success: (res) => {
					this.loadModal.show = false;
					if(res.data.success){
						this.datalist = res.data.success.data;
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
		
		// 数据详情页面跳转
		getDetails(url){
			let dateType = this.activeInde == 0 ? 'day' : 'month';
			uni.navigateTo({
				url: url + '?uid=' + this.uid + '&date_type=' + dateType + '&type=agent'
			})
		},
		
		// 选择日期回调函数
		changeDatetimePicker(date){
			this.loadModal.show = true;
			
			this.date = date.YYYY + '-' + date.MM;
			this.getTeamDetail();
		}
	}
};
</script>

<style>
@import '../../style/trade_details.css';
</style>
