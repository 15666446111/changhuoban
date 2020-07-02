import baseurl from './config.js';

// 公共的请求
const net = function(options) {
	// 设置请求url
    options.url = baseurl + options.url;
	// 尝试请求接口
    try {
		// 获取token
		const token 	= uni.getStorageSync('token');
		
		const operate 	= uni.getStorageSync('operate');
		
		const type 	= uni.getStorageSync('type');
		
		
		if (token == ''){
			// 如果没有token  定位到登陆页面
            uni.redirectTo({
                url: '/pages/index/index'
            });

            return;
        }

		if (operate == ''){
			// 如果没有operate  定位到登陆页面
            uni.redirectTo({
                url: '/pages/index/index'
            });

            return;
        }

		if (type == ''){
			// 如果没有operate  定位到登陆页面
            uni.redirectTo({
                url: '/pages/index/index'
            });

            return;
        }
		// 发起请求
		uni.request({
			url: options.url,
			header: {'Authorization' : 'Bearer ' + token},
			method: options.method,
			data: options.data,
			success: (res) => {
				if (res.statusCode == 200) {
					options.success(res);
				}
				// token失效时，跳转登录页面
				if (res.statusCode == 505) {
					uni.showToast({
						title: res.data.error.message,
						icon: 'none',
						mask: true
					})
					
					setTimeout(function() {
						uni.redirectTo({
							url: '/pages/index/index'
						})
					}, 1000);
					return;
				}
				
			}
		})
     } catch (err) {
		// 如果请求出错  打印错误信息
      	uni.showToast({
			title: '系统错误，请联系客服',
			icon: 'none'
		})
    }
	
	// 返回请求
	// return uni.request(options);
}
export default net;