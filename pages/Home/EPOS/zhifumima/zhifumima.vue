<template>
	<view>
		<!-- 信息填写 -->
		<view class="selects">
			<!-- 第一栏 -->
			<view class="select">
				<view class="select-view">
					<view class="select-name">手机号</view>
					<view class="select-text">158****1563</view>
				</view>
				<view class="hengxian"></view>
				<view class="select-view1">
					<view class="select-name">验证码</view>
					<input class="select-text1" placeholder="请输入验证码" placeholder-class="place" />
					<view class="select-text2">获取验证码</view>
				</view>
				<view class="hengxian"></view>
				<view class="select-view">
					<view class="select-name">新密码</view>
					<input class="select-text" placeholder="请输入6位纯数字密码" placeholder-class="place" />
				</view>
				<view class="hengxian"></view>
				<view class="select-view">
					<view class="select-name">确认新密码</view>
					<input class="select-text" placeholder="确认新密码" placeholder-class="place" />
				</view>
			</view>
		</view>
		<button id="button-1"> 确 认 修 改 </button>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				
			}
		},
		methods: {
			
		}
	}
</script>

<style>
  /* 填写信息 */
  .selects {
    width: 100%;
    background-color: #fff;
	margin-top: 2%;
/* 	margin-left: 5%;
    margin-top: 2%;
    border-radius: 4px 4px 4px 4px;
	box-shadow: #ddd 3px 3px 8px 3px; */
  }
  
  .select-view {
    display: flex;
    height: 90rpx;
	position: relative;
  }
  .select-view1 {
    display: flex;
    height:90rpx;
  	position: relative;
  }
  
  .select-image {
    width: 1.4rem;
    position: absolute;
	right: 1rem;
	top: 0.3rem;
  }
  
  .select-name {
	font-size: 0.8rem;
    margin-left: 1rem;
	margin-top: 3%;
	width: 25%;
  }
  
  .select-text {
    color: #666;
  	font-size: 0.7rem;
  	border: 0;
  	margin-left: 30upx;
  	margin-top: 4%;

  }
  .select-text1 {
    color: #666;
  	font-size: 28upx;
  	border: 0;
  	margin-left: 30upx;
  	margin-top: 4%;
	width: 30%;

  }
  .select-text2{
	  color: #f64547;
	  font-size: 20upx;
	  border: 0;
	  margin-top: 3%;
	  border: 1upx solid #f64547;
	  height: 40upx;
	  width: 150upx;
	  text-align:center;
	  border-radius: 10px 10px 10px 10px;
  }
	  
  .hengxian {
    width: 94%;
    height: 1px;
    background-color: #dbdada;
    margin-left: 3%;
  }
  /* 按钮 */
  
 button{
  width: 80%;
 background: linear-gradient(to right, #fe695a, #f64547);
  color: #fff;
  height: 85rpx;
  margin-left: 10%;
  border: 0;
  border-radius: 0.3rem;
  margin-top: 2rem;
  font-size: 0.9rem;
}
</style>

