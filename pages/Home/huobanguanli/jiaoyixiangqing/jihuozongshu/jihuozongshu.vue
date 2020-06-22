<template>
		<view class="teams">
			<!-- 直营业绩 -->
			<view class="team">
				<view class="the">直营业绩</view>
				<view class="across"></view>
				<view class="view" >
					<view class="jiaoyi">
						<view class="jiaoyi-text">MP70</view>
						<view class="jiuaoyi-shuzi">40</view>
					</view>
					<view class="hengxian"></view>
					<view class="jiaoyi">
						<view class="jiaoyi-text">H9</view>
						<view class="jiuaoyi-shuzi">40</view>
					</view>
					<view class="hengxian"></view>
					<view class="jiaoyi">
						<view class="jiaoyi-text">EPOS</view>
						<view class="jiuaoyi-shuzi">40</view>
					</view>
					
				</view>
			</view>
			<view class="team">
				<view class="the">代理业绩</view>
				<view class="across"></view>
				<view class="view" >
					<view class="jiaoyi">
						<view class="jiaoyi-text">MP70</view>
						<view class="jiuaoyi-shuzi">40</view>
					</view>
					<view class="hengxian"></view>
					<view class="jiaoyi">
						<view class="jiaoyi-text">H9</view>
						<view class="jiuaoyi-shuzi">40</view>
					</view>
					<view class="hengxian"></view>
					<view class="jiaoyi">
						<view class="jiaoyi-text">EPOS</view>
						<view class="jiuaoyi-shuzi">40</view>
					</view>
				</view>
			</view>
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
  /*  */
  .teams {
    width: 100%;
    height: 100%;
  }
  .team {
    width: 90%;
    background-color: #fff;
    margin-top: 2%;
    margin-left: 5%;
    border-radius: 10px 10px 10px 10px;
    box-shadow: #ddd 3px 3px 8px 3px;
    overflow: hidden;
  }
  .the {
    width: 100%;
    margin-left: 5%;
    margin-top: 2%;
    font-weight: 600;
    color:  #ff8c00;
	font-size: 1rem;
  }
  .across {
    height: 1px;
    width: 92%;
    background-color: rgb(175, 175, 175);
    margin-top: 2%;
    margin-left: 4%;
  }
  
  /**/
  
  .jiaoyi{
    display: flex;
    height: 100upx;
    position: relative;
    width: 90%;
  }
  .hengxian{
    width: 92%;
    height: 1px;
    background-color:rgb(175, 175, 175);
    margin-left: 4%;
  }
  .jiaoyi-text{
	  font-size: 0.8rem;
	  margin-left: 1rem;
	  margin-top: 4%;
  }
  .jiuaoyi-shuzi{
    position: absolute;
    color:  #ff8c00;
    font-weight: 600;
	right: 1px;
	top: 30upx;
    font-size: 0.8rem;
  }
</style>
