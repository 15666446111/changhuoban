<template>
	<section class="Tabs-Page">
		<s-tabs :effect="true" v-model="activeTab" @change="change" :nav-per-view="5">

			<s-tab title="注册">
				<view class="bviews" v-for="(item,index) in Register" :key="item.id">
					<view class="bview1">
						<view class="title">{{ item.title }}</view>
						<view class="time">{{ item.created_at }}</view>
						<text class="text">{{ item.message_text }}</text>
					</view>
				</view>
			</s-tab>
			
			<s-tab title="订单">
				<view class="bviews" v-for="(item,index) in Order" :key="item.id">
					<view class="bview1">
						<view class="title">{{ item.title }}</view>
						<view class="time">{{ item.created_at }}</view>
						<text class="text">{{ item.message_text }}</text>
					</view>
				</view>
			</s-tab>
			
			<s-tab title="收益">
				<view class="bviews" v-for="(item,index) in Income" :key="item.id">
					<view class="bview1">
						<view class="title">{{ item.title }}</view>
						<view class="time">{{ item.created_at }}</view>
						<text class="text">{{ item.message_text }}</text>
					</view>
				</view>
			</s-tab>
			
			<s-tab title="实名">
				<view class="bviews" v-for="(item,index) in Realname" :key="item.id">
					<view class="bview1">
						<view class="title">{{ item.title }}</view>
						<view class="time">{{ item.created_at }}</view>
						<text class="text">{{ item.message_text }}</text>
					</view>
				</view>
			</s-tab>
			
			<s-tab title="其他">
				<view class="bviews" v-for="(item,index) in Other" :key="item.id">
					<view class="bview1">
						<view class="title">{{ item.title }}</view>
						<view class="time">{{ item.created_at }}</view>
						<text class="text">{{ item.message_text }}</text>
					</view>
				</view>
			</s-tab>
		</s-tabs>
	</section>
</template>

<script>
import sTabs from '@/s-ui/s-tabs';
import sTab from '@/s-ui/s-tab';
import net from '../../../common/net.js';

import await_net from '../../../common/await_net.js';

export default {
	
	components: { sTabs, sTab },
	
	data() {
		return {
			tabIndex: 0,
			srcollinto: '',
			scrollH: 500,
			activeTab: 0,
			
			Register: [],
			Order: [],
			Income: [],
			Realname: [],
			Other: [],
		
			index: 0,
			arr: ['Register', 'Order', 'Income', 'Realname', 'Other'],
		};
	},
	
	onLoad() {
		this.getMessage(this.arr[this.index]);
		// this.getMessage('Register');
	},
	
	methods: {
		getmsg(){
			if(this.index >= this.arr.length){
				return false;
			}
			
			this.getMessage(this.arr[this.index])
		},		
		
		getMessage(type) {
	    	await_net(
	        	"/V1/message",
	            { type:  type},
	      	)
			.then((res) => {
				// console.log(res);
				if(type == 'Register'){
					this.Register = res.data.success.data;
				}
				if(type == 'Order'){
					this.Order = res.data.success.data;
				}
				if(type == 'Income'){
					this.Income = res.data.success.data;
				}
				if(type == 'Realname'){
					this.Realname = res.data.success.data;
				}
				if(type == 'Other'){
					this.Other = res.data.success.data;
				}				
				this.index++;
				this.getmsg()
			})
		},
	
	},
	
};
</script>

<style>
@import '../style/user_message.css';
</style>
