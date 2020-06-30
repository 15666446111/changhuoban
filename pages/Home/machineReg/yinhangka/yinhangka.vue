<template>
	<view>
		<!-- 头部注释 -->
		<view class="heads">
			<view class="head">
				<view class="head-view">
					<image class="head-image" src="../../../../static/shuzi/1-h.png" />
					<view class="head-xian"></view>
				</view>
				<view class="head-text ">个人信息</view>
			</view>
		
			<view class="head">
				<view class="head-view">
					<image class="head-image" src="../../../../static/shuzi/2-h.png" />
					<view class="head-xian"></view>
				</view>
				<view class="head-text">商户信息</view>
			</view>
		
			<view class="head">
				<view class="head-view">
					<image class="head-image" src="../../../../static/shuzi/3.png" />
					<view class="head-xian"></view>
				</view>
				<view class="head-text croci">结算信息</view>
			</view>
		
			<view class="head">
				<view class="head-view">
					<image class="head-image" src="../../../../static/shuzi/4-h.png" />
				</view>
				<view class="head-text">商户开通</view>
			</view>
		</view>
		
		<!-- 信息填写 -->
		<view class="selects">
			<view class="select">
			</view>
			<!-- 第一栏 -->
			<view class="select">
				<view class="select-view">
					<view class="select-name">银行卡号</view>
					<input class="select-text" placeholder="请输入银行卡号" placeholder-class="place"></input>
				</view>
				<view class="hengxian"></view>
				<!-- 第二栏 -->
				<view class="select-view">
					<view class="select-name">身份证号</view>
					<input class="select-text" placeholder="请输入商户身份证号" placeholder-class="place"></input>
				</view>
				<view class="hengxian"></view>
				<!-- 第三栏 -->
				<view class="select-view">
					<view class="select-name">预留手机号</view>
					<input class="select-text" placeholder="请输入预留手机号" placeholder-class="place"></input>
				</view>
				<view class="hengxian"></view>
				<!-- 第四栏 -->
				<view class="select-view1">
					<view class="select-name">验证码</view>
					<input class="select-text1" placeholder="请输入验证码" placeholder-class="place"></input>
					<view class="select-text2">获取验证码</view>
				</view>
			</view>
		</view>
		<!-- 照片信息 -->
		<view class="picture">
			<view class="photograph">
				<image class="photograph-image" src="../../../../static/shuzi/bank_card.jpg" />
				<image class="photograph-image" src="../../../../static/shuzi/bank_card2.jpg" />
			</view>
		</view>
<navigator url="../querenxinxi/querenxinxi">
			<button id="button-1"> 下 一 步 </button>
</navigator>
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
  /*  注释*/
  .heads{
   display: flex;
   background-color: #fff;
   width: 100%;
   box-shadow: #ddd 0px 3px 5px 0px;
   height: 2.2rem;
  }
.head {
  width: 25%;
  position: relative;
}

.head-view{
  display: flex;
  margin-left: 70rpx;
}

.head-image {
  width: 0.8rem;
  height: 0.8rem;
  margin-left: 5%;
}

.head-xian {
  width: 2rem;
  height: 1px;
  background-color: #dbdada;
  position: absolute;
  left: 4rem;
  top: 0.5rem;
}

.head-text {
  font-size: 0.6rem;
  margin-top: 0.25rem;
  text-align: center;
  color: #999;
}
.croci{
	color: #F98021;
}
  
  /* 填写信息 */
  .selects {
    width: 90%;
    margin-left: 5%;
    background-color: #fff;
    margin-top: 2%;
    border-radius: 4px 4px 4px 4px;
	box-shadow: #ddd 3px 3px 8px 3px;
  }
  
  .select-view {
    display: flex;
    height: 100upx;
	position: relative;
  }
  .select-view1 {
    display: flex;
    height:100upx;
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
	margin-top: 3.3%;
	width: 25%;
  }
  
  .select-text {
    color: #666;
  	font-size: 0.7rem;
  	border: 0;
  	margin-left: 1rem;
  	margin-top: 5%;

  }
  .select-text1 {
    color: #666;
  	font-size: 0.7rem;
  	border: 0;
  	margin-left: 1rem;
  	margin-top: 5%;
	width: 30%;

  }
  .select-text2{
	  color: #f98021;
	  font-size: 0.6rem;
	  border: 0;
	  margin-left: 1rem;
	  margin-top: 4%;
  }
	  
  .hengxian {
    width: 94%;
    height: 1px;
    background-color: #dbdada;
    margin-left: 3%;
  }
  /* 照片信息 */
  .picture{
    width: 90%;
    height: 100%;
    background-color: #fff;
    margin-left: 5%;
    border-radius: 4px 4px 4px 4px;
    box-shadow: #ddd 3px 3px 8px 3px;
    overflow: hidden;
	margin-top: 2%;
  }

  .photograph{
    height: 6.5rem;
	margin-top: 2%;
  }
  .photograph-image{
    width: 40%;
	height: 5rem;
    margin-left: 5%;
    box-shadow: #d3d3d3 0 0 4px 0;
	margin-top: 3%;
  }
 
  /* 按钮 */
  
 button{
  width: 80%;
  background-color: #f0ad4e;
  color: #fff;
  height: 85rpx;
  margin-left: 10%;
  border: 0;
  border-radius: 0.3rem;
  margin-top: 2rem;
  font-size: 0.9rem;
}
</style>
