<style>
/*每个页面公共css */
/* 官方UI库 */
@import url('/common/uni.css');
/* 自定义图标库 */
@import url('/common/icon.css');
/* UI基础库 */
@import url('/common/zcm-main.css');
/* 公共样式 */
@import url('/common/common.css');
/* 全局图标样式*/
@import '/common/iconfont.css';

/* colorui */
@import 'colorui/main.css';
@import 'colorui/icon.css';

uni-checkbox .uni-checkbox-input {
	border-radius: 50% !important;
	color: #ffffff !important;
	transform: scale(0.8, 0.8);
}

uni-checkbox .uni-checkbox-input.uni-checkbox-input-checked {
	color: #fff;
	border-color: #ee4000;
	background: #ee4000;
}
uni-checkbox .uni-checkbox-input.uni-checkbox-input-checked:after {
	font-size: 18px;
}
::-webkit-scrollbar {
	display: none;
	width: 0 !important;
	height: 0 !important;
	-webkit-appearance: none;
	background: transparent;
}
*,
*:after,
*:before {
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
	-webkit-tap-highlight-color: rgba(0, 0, 0, 0);
	-webkit-touch-callout: none;
	-webkit-user-drag: none;
	/* -webkit-user-select: none; */
	-ms-user-select: none;
	-ms-touch-action: none;
	-moz-user-select: -moz-none;
}
</style>
<script>
	export default {
		onLaunch: function () {
			//#ifdef APP-PLUS  
			var server = "http://livechb3.changhuoban.com/api/V1/appUpdate"; //检查更新地址  
			var req = { //升级检测数据
				"appid": plus.runtime.appid,
				"version": plus.runtime.version
			};
			console.log(req);
			
			uni.request({
				url: server,
				data: req,
				success: (res) => {
					// if (res.statusCode == 200 &amp;&amp; res.data.status === 1) {
					if (res.data.success && res.data.success.url != undefined) {
						uni.showModal({ //提醒用户更新
							title: "更新提示",
							content: '系统优化',
							success: (result) => {
								if (result.confirm) {
									plus.runtime.openURL(res.data.success.url);
								}
							}
						})
					}
				}
			})  
			//#endif  
		}
	};
	
</script>