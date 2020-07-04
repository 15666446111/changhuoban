<template>
	<view>
		<!-- 输入框 -->
		<view class="indexs">
			<!-- 第一栏 -->
			<view class="select">
				<view class="select-view">
					<view class="select-name">姓名</view>
					<input class="select-text" placeholder="请输入您的姓名" v-model="name" >
				</view>
				<view class="hengxian"></view>
			</view>
			
			<view class="select-view">
				<view class="select-name">身份证号</view>
				<input class="select-text" placeholder="请输入您的身份证号" v-model="number" value="" />
			</view>
			<view class="hengxian"></view>
			
			<view class="select">
				<view class="select-view">
					<view class="select-name">银行</view>
					<input class="select-text" placeholder="请输入银行名称" v-model="bank_name"/>
				</view>
				<view class="hengxian"></view>
				
				<view class="select-view">
					<view class="select-name">银行卡号</view>
					<input class="select-text" placeholder="请输入银行卡号" v-model="bank" value="" />
				</view>
				<view class="hengxian"></view>
				
				<view class="select-view">
					<view class="select-name">开户行</view>
					<input class="select-text" placeholder="请输入开户行" v-model="open_bank"/>
				</view>
				<view class="hengxian"></view>
				
				<view class="select-view">
					<view class="select-name">省</view>
					<input class="select-text" placeholder="请输入省" v-model="province"/>
				</view>
				<view class="hengxian"></view>
				
				<view class="select-view">
					<view class="select-name">市</view>
					<input class="select-text" placeholder="请输入市" v-model="city"/>
				</view>
				<view class="hengxian"></view>
				
				
				<view class="select-view">
					<checkbox-group @change="defaultType">
						<label>
							<checkbox class="se-defulat" value="1" color="#FF8C00" />设为默认
						</label>
					</checkbox-group>
				</view>
			</view>
		</view>
		<button @click="submit">确 定</button>
	</view>
</template>

<script>
import net from '../../../../common/net.js';

export default {
	data() {
		return {
			name: '',
			number: '',
			bank_name: '',
			bank: '',
			open_bank: '',
			is_default: 0,
			province:'',
			city: '',
		};
	},
	
	onLoad() {
		
	},
	methods: {
		defaultType(e){
			this.is_default = (e.detail.value == 1 ? 1 : 0);
		},
		
		submit(){
			if (this.name == '') {
				uni.showToast({
					title: '姓名不能为空',
					icon: 'none'
				});
				return false;
			}
			
			if (this.number == '') {
				uni.showToast({
					title: '身份证号不能为空',
					icon: 'none'
				});
				return false;
			}
			
			if (this.bank_name == '') {
				uni.showToast({
					title: '银行名称不能为空',
					icon: 'none'
				});
				return false;
			}
			
			if (this.bank == '') {
				uni.showToast({
					title: '银行卡号不能为空',
					icon: 'none'
				});
				return false;
			}
			
			if (this.open_bank == '') {
				uni.showToast({
					title: '开户行不能为空',
					icon: 'none'
				});
				return false;
			}
			
			if (this.province == '') {
				uni.showToast({
					title: '省份不能为空',
					icon: 'none'
				});
				return false;
			}
			
			if (this.city == '') {
				uni.showToast({
					title: '市不能为空',
					icon: 'none'
				});
				return false;
			}
			
			uni.showLoading({
				mask: true
			});
			net({
	        	url: "/V1/createBank",
	            method: 'POST',
				data: {
					name: this.name,
					number: this.number,
					bank_name: this.bank_name,
					bank: this.bank,
					open_bank: this.open_bank,
					is_default: this.is_default,
					province: this.province,
					city: this.city,
				},
	            success: (res) => {
					if (res.data.success) {
						uni.showToast({
							title: res.data.success.message,
							icon: 'none',
							success : function(){
								setTimeout(function() {
									uni.hideLoading();
									// uni.navigateBack();
								}, 1500);
							}
						});
					} else {
						uni.showToast({
							title: res.data.error.message,
							icon: 'none'
						});
					}
	            }
	      	})
		}
	}
};
</script>

<style>
@import url("../../style/settle_card.css");
</style>
