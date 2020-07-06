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
						<view class="time">{{ datalist.date }}</view>
					</view>
					
					<view class="data">
						<navigator url="../jinrijiaoyi/jinrijiaoyi">
							<view class="data-s">
								<view class="deal">今日交易</view>
								<view class="money">{{ datalist.trade }}</view>
								<image class="image" src="/static/jiantou.png" mode="aspectFit" />
							</view>
						</navigator>
						<view class="hengxian"></view>
					</view>

					<view class="data">
						<navigator :url="'../jihuozongshu/jihuozongshu?uid='+activeIndex">
							<view class="data-s">
								<view class="deal">激活总数</view>
								<view class="money">{{ datalist.activeCount }}</view>
								<image class="image" src="/static/jiantou.png" mode="aspectFit" />
							</view>
						</navigator>
						<view class="hengxian"></view>
					</view>		

					<view class="data">
						<navigator :url="'../TemailCount/TemailCount?uid='+activeIndex">
							<view class="data-s">
								<view class="deal">机具总数</view>
								<view class="money">{{ datalist.merchants }}</view>
								<image class="image" src="/static/jiantou.png" mode="aspectFit" />
							</view>
						</navigator>
						<view class="hengxian"></view>
					</view>					

					<view class="data">
						<navigator url="../shouyizongshu/shouyizongshu">
							<view class="data-s">
								<view class="deal">收益总数</view>
								<view class="money">{{ datalist.income }}</view>
								<image class="image" src="/static/jiantou.png" mode="aspectFit" />
							</view>
						</navigator>
						<view class="hengxian"></view>
					</view>	

					<view class="data">
						<navigator :url="'../huobanzongshu/huobanzongshu?uid='+activeIndex">
							<view class="data-s">
								<view class="deal">伙伴总数</view>
								<view class="money">{{ datalist.friends }}</view>
								<image class="image" src="/static/jiantou.png" mode="aspectFit" />
							</view>
						</navigator>
						<view class="hengxian"></view>
					</view>	

					<view class="data">
						<navigator :url="'../shanghuzongshu/shanghuzongshu?uid='+activeIndex">
							<view class="data-s">
								<view class="deal">商户总数</view>
								<view class="money">{{ datalist.merchants }}</view>
								<image class="image" src="/static/jiantou.png" mode="aspectFit" />
							</view>
						</navigator>
						<view class="hengxian"></view>
					</view>

					<view class="data">
						<navigator url="../taijunjiaoyi/taijunjiaoyi">
							<view class="data-s">
								<view class="deal">台均交易量</view>
								<view class="money">{{ datalist.Avg }}</view>
								<image class="image" src="/static/jiantou.png" mode="aspectFit" />
							</view>
						</navigator>
						<view class="hengxian"></view>
					</view>


				</view>
				
				
			</view>
		</view>
	</view>
</template>

<script>
	
import net from '../../../common/net.js';

export default {
	data() {
		return {
			activeInde: 0,
			activeIndex: 1,
			uid: 0,
			agency: [],
			select: [{ name: '按日查询' }, { name: '按月查询' }],
			datalist: [],
		};
	},
	
	// 页面加载的时候初始化数据
	onLoad(){
		uni.showLoading();
		// 获取当前登陆用户id
		this.getUserInfo();
		// 获取展示数据 团队信息
		this.getTeamList();
		this.getTeamDetail();
	},
	
	methods: {
		changeCate(index) {
			if(this.activeIndex != index){
				let type = this.activeInde == 0 ? 'day' : 'month';
				this.getTeamDetail(type, index);
				this.activeIndex = index;
			}
		},
		changecate(index) {
			// 按月查询 按日查询
			if( this.activeInde !== index){
				if(index == 0){
					uni.showLoading()
					this.getTeamDetail('day', this.activeIndex);
				}
				if(index == 1){
					uni.showLoading()
					this.getTeamDetail('month', this.activeIndex);
				}
				this.activeInde = index;
			}
			
		},
		
		getUserInfo(){
	    	net({
	        	url:"/V1/userInfo",
	            method:'get',
	            success: (res) => {
					uni.hideLoading();
					this.uid = res.data.success.data.id;
					this.activeIndex = res.data.success.data.id;
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
		
					uni.hideLoading();
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
		getTeamDetail(type, uid){
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
@import '../style/trade_detail.css';
</style>
