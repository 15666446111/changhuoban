<template>
	<view class="body">
		<!-- 日数据 -->
		
		<view class="teams">
			<view class="datas">
				<view class="bay">
					<view class="bay-view">
						<text class="the-text">今天汇总</text>
						<text class="the-text-1">{{ TeamInfo.day.date }}</text>
						<text class="the-text-2">日</text>
					</view>
					<view class="d-flex" style="height:100upx;">
						<view class="data-div1">
							<view class="data-text2">{{ TeamInfo.day.trade }}</view>
							<view class="data-text2">交 易(元)</view>
						</view>
						<view class="vertical1"></view>
						<view class="data-div1">
							<view class="data-text2">{{ TeamInfo.day.income }}</view>
							<view class="data-text2">收 益(元)</view>
						</view>
					</view>
				</view>
			</view>
			<view class="data">
				<view class="data-div">
					<view class="data-text1">{{ TeamInfo.day.active }}</view>
					<view class="data-text">激 活(台)</view>
				</view>
				<view class="vertical"></view>

				<view class="data-div">
					<view class="data-text1">{{ TeamInfo.day.merchant }}</view>
					<view class="data-text">商 户(个)</view>
				</view>

				<view class="vertical"></view>

				<view class="data-div">
					<view class="data-text1">{{ TeamInfo.day.team }}</view>
					<view class="data-text">伙 伴(个)</view>
				</view>
			</view>
		</view>
		<!-- 月数据 -->

		<view class="teams">
			<view class="datas">
				<view class="month">
					<view class="bay-view">
						<text class="the-text">本月汇总</text>
						<text class="the-text-1">{{ TeamInfo.month.date }}</text>
						<text class="the-text-2">月</text>
					</view>
					<view class="d-flex" style="height:100upx;">
						<view class="data-div1">
							<view class="data-text2">{{ TeamInfo.month.trade }}</view>
							<view class="data-text2">交 易(元)</view>
						</view>
						<view class="vertical1"></view>
						<view class="data-div1">
							<view class="data-text2">{{ TeamInfo.month.income }}</view>
							<view class="data-text2">收 益(元)</view>
						</view>
					</view>
				</view>
			</view>
			<view class="data">
				<view class="data-div">
					<view class="data-text1">{{ TeamInfo.month.active }}</view>
					<view class="data-text">激 活(台)</view>
				</view>
				<view class="vertical"></view>

				<view class="data-div">
					<view class="data-text1">{{ TeamInfo.month.merchant }}</view>
					<view class="data-text">商 户(个)</view>
				</view>

				<view class="vertical"></view>

				<view class="data-div">
					<view class="data-text1">{{ TeamInfo.month.team }}</view>
					<view class="data-text">伙 伴(个)</view>
				</view>
			</view>
		</view>
		
		<!-- 总数据 -->
		<view class="teams">
			<view class="datas">
				<view class="year">
					<view class="bay-view">
						<text class="the-text">累计汇总</text>
						<text class="the-text-1"></text>
						<text class="the-text-2">{{ TeamInfo.all.date }}</text>
					</view>
					<view class="d-flex" style="height:100upx;">
						<view class="data-div1">
							<view class="data-text2">{{ TeamInfo.all.trade }}</view>
							<view class="data-text2">交 易(元)</view>
						</view>
						<view class="vertical1"></view>
						<view class="data-div1">
							<view class="data-text2">{{ TeamInfo.all.income }}</view>
							<view class="data-text2">收 益(元)</view>
						</view>
					</view>
				</view>
			</view>
			<view class="data">
				<view class="data-div">
					<view class="data-text1">{{ TeamInfo.all.active }}</view>
					<view class="data-text">激 活(台)</view>
				</view>
				<view class="vertical"></view>

				<view class="data-div">
					<view class="data-text1">{{ TeamInfo.all.merchant }}</view>
					<view class="data-text">商 户(个)</view>
				</view>

				<view class="vertical"></view>

				<view class="data-div">
					<view class="data-text1">{{ TeamInfo.all.team }}</view>
					<view class="data-text">伙 伴(个)</view>
				</view>
			</view>
		</view>
		
		<navigator url="tradeTeam/tradeTeam">
			<button class="button">业 务 详 情</button>
		</navigator>
		
		<view style="height: 130upx;"></view>
		
	</view>
</template>

<script>
import net from '../../common/net.js';

export default {
	
	data() {
		return {
			TeamInfo:{
				day:{
					trade: 0.01,
					active: 10,
					merchant: 20,
					income: 100.00,
					team: 30,
				},
				month:{
					"trade": "0.00",
					"active": 100,
					"merchant": 0,
					"income": "0.00",
					"team": 0,
				},
				all:{
					"trade": "0.00",
					"active": 0,
					"merchant": 0,
					"income": "0.00",
					"team": 0,	
				}
			}
			
			
		};
	},
	
	// 页面加载的时候初始化数据
	onLoad(){
		uni.showLoading();
		// 获取展示数据 团队信息
		this.getTeamInfo();
	},
	
	
	methods: {
		// 获取团队数据
		getTeamInfo(){
	    	net({
	        	url:"/V1/team_data",
	            method:'get',
	            success: (res) => {
					uni.hideLoading();
					if(res.data.success){
						this.TeamInfo = res.data.success.data;
					}else
						uni.showToast({ title: res.data.error.message, icon: 'none', position: 'bottom' });
	            }
	      	})
		},
		
	}
};
</script>

<style>
@import 'style/team.css';
</style>
