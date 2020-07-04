格式化器：
支持日期格式化、格式化数字显示、格式化金额、格式化星期、小写金额转大写、文件格式化

使用：
日期格式使用：
2018-02-24 23:28:28 :
var date=formatter.formatDateTime(new Date());
2018-02-24
var date=formatter.formatDate(new Date(),"yyyy-MM-dd");
2018/02/24
var date=formatter.formatDate(new Date(),"yyyy/MM/dd");
2018-02-24 23:28
var date=formatter.formatDate(new Date(),"yyyy-MM-dd HH:mm");

格式化数字显示方式:
123,45.999
var money=formatter.formatNumber(12345.999,'#,##0.00'); 
星期五
var week=formatter.formatWeek("五");
小写转大写
一千二百三十四
var  chinese=formatter.formatMoneyAuto("1234");
文件大小转化：
1Kb
var fileSize=formatter.formatFileSize("1024");

1Mb
var fileSize=formatter.formatFileSize("1024*1024");


案例：
<script>
import formatter from '@/common/formatter.js';
export default {
	data() {
		return {
			appcache: '0Mb'
		};
	},
	onLoad(e) {
		var self = this;
		// #ifdef APP-PLUS
		// 获取当前应用缓存大小并转化为MB、KB、GB等格式
		plus.cache.calculate(function(size) {
			console.log(size);
			self.appcache = formatter.formatFileSize(size);
		});
		// #endif
	},	
};
</script>