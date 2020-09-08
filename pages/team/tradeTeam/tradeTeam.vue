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
				<!-- 代理栏 -->
				<view class=" agency">
					
					<view :key="uid" @tap="changeCate(uid)">
						<view class="agency-view">
							<view class="agency-text" :class="activeIndex === uid ? 'agency-text2' : ''">我的</view>
						</view>
						<view class="agency-xian"></view>
					</view>					
					
					<view v-for="(item, index) in agency" :key="item.id" @tap="changeCate(item.id)" v-if="item.id != uid">
						<view class="agency-view">
							<view class="agency-text" :class="activeIndex === item.id ? 'agency-text2' : ''">{{ item.nickname }}</view>
						</view>
						<view class="agency-xian"></view>
					</view>
					
				</view>
				
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
							<image src="../../../static/calendar.png" class="calendar-img" mode="widthFix" style="width: 56rpx;"></image>
						</view>
					</view>
					
					<view class="data">
						<!-- <view class="data-s" @click="getDetails('../data_details/trade')"> -->
						<view class="data-s">
							<view class="deal">交易总数</view>
							<view class="money">{{ datalist.trade }}</view>
							<image class="image" src="/static/jiantou.png" mode="aspectFit" />
						</view>
						<view class="hengxian"></view>
					</view>

					<view class="data">
						<!-- <view class="data-s" @click="getDetails('../data_details/active')"> -->
						<view class="data-s">
							<view class="deal">激活总数</view>
							<view class="money">{{ datalist.activeCount }}</view>
							<image class="image" src="/static/jiantou.png" mode="aspectFit" />
						</view>
						<view class="hengxian"></view>
					</view>		

					<view class="data">
						<!-- <view class="data-s" @click="getDetails('../data_details/temail')"> -->
						<view class="data-s">
							<view class="deal">机具总数</view>
							<view class="money">{{ datalist.temails }}</view>
							<image class="image" src="/static/jiantou.png" mode="aspectFit" />
						</view>
						<view class="hengxian"></view>
					</view>					

					<view class="data">
						<!-- <view class="data-s" @click="getDetails('../data_details/profit')"> -->
						<view class="data-s">
							<view class="deal">收益总数</view>
							<view class="money">{{ datalist.income }}</view>
							<image class="image" src="/static/jiantou.png" mode="aspectFit" />
						</view>
						<view class="hengxian"></view>
					</view>	

					<view class="data">
						<!-- <view class="data-s" @click="getDetails('../data_details/team_user')"> -->
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

					<view class="data" v-if="activeInde == 1">
						<!-- <view class="data-s" @click="getDetails('../data_details/average_trade')"> -->
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
		
		<view class="cu-load load-modal" v-if="loadModal.show">
		   <image src="/static/public/loading.png" mode="aspectFit"></image>
		   <view class="gray-text">{{ loadModal.text }}</view>
		</view>
	</view>
</template>

<script>
	
import net from '../../../common/net.js';
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
			activeInde: 0,	//0：按日查询，1：按月查询
			activeIndex: 0,
			uid: 0,			// 当前登录用户id
			agency: [],
			select: [{ name: '按日查询' }, { name: '按月查询' }],
			datalist: [],
			date: ''
			
		};
	},
	
	// 页面加载的时候初始化数据
	onLoad(){
		this.loadModal.show = true;
		// 获取当前登陆用户id
		this.getUserInfo();
		// 获取展示数据 团队信息
		this.getTeamList();
	},
	
	methods: {
		changeCate(index) {
			if(this.activeIndex != index){
				this.activeIndex = index;
				
				this.loadModal.show = true;
				this.getTeamDetail();
			}
			
		},
		changecate(index) {
			// 按月查询 按日查询
			if( this.activeInde !== index){
				this.activeInde = index;
				
				this.loadModal.show = true;
				this.getTeamDetail();
			}
			
		},
		
		// 获取当前用户登录信息
		getUserInfo(){
	    	net({
	        	url:"/V1/userInfo",
	            method:'get',
	            success: (res) => {
					if (res.data.success) {
						this.uid = res.data.success.data.id;
						this.activeIndex = res.data.success.data.id;
						
						// 获取详细数据
						this.getTeamDetail();
					} else {
						uni.showToast({
							title: res.data.error.message,
							icon: 'none',
							position: 'bottom'
						});
					}
					
					
					
	            }
	      	})
		},
		
		/**
		 *  @version 获取直接下级列表
		 */
		getTeamList(){
	    	net({
	        	url:"/V1/my_team",
	            method:'get',
	            success: (res) => {
					this.loadModal.show = false;
					let list = res.data.success.data.list;
					
					this.agency = list.filter(item =>{  
						return item.id!== this.uid;  
					})
	            }
	      	})
		},
		
		/**
		 * @version 获取详细数据
		 */
		getTeamDetail(){
			let dataType = this.activeInde == 0 ? 'day' : 'month';

	    	net({
	        	url:"/V1/getTradeDetail",
	            method:'post',
				data:{
					current: 'team',
					data_type: dataType,
					uid: this.activeIndex,
					date: this.date
				},
	            success: (res) => {
					this.loadModal.show = false;
					if(res.data.success){
						this.datalist = res.data.success.data;
					}
					
					if(res.data.error){
						
					}
	            }
	      	})
		},
		
		// 数据详情页面跳转
		getDetails(url){
			let dateType = this.activeInde == 0 ? 'day' : 'month';
			let type = this.activeIndex == this.uid ? 'self' : 'agent';
			uni.navigateTo({
				url: url + '?uid=' + this.activeIndex + '&date_type=' + dateType + '&type=' + type + '&date=' + this.date
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
@import '../style/trade_detail.css';

.placeholder {
	line-height: 50rpx;
}
</style>
