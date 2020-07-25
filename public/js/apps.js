$(function() { 
	$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
	/**
	 * @version  Register Page 
	 * @author   Pudding
	 * @data     2020 0413 
	 */
	// 立即注册
	$("#Register").click(function(){

		$(this).html("正在注册,请稍后..");
		$(this).attr('disabled', true);
		$(this).addClass('button_active');
		//$.showLoading();
	    //$.hideLoading();
	    
	    // 检查是否勾选阅读条款
	    if(!$("#weuiAgree").is(":checked")){
	    	$.toptip('请同意 服务条款', 'error');
	    	//$.toast("", "forbidden");
	    	$(this).html("立即注册");
	    	$(this).attr('disabled', false);
	    	$(this).removeClass('button_active');
	        return false; 
	    }

		var phone = $("input[name=register_phone]").val();

	    if(!(/^1[3456789]\d{9}$/.test(phone))){
	    	$.toptip('手机号码有误', 'error');
	    	//$.toast("", "forbidden");
	    	$(this).html("立即注册");
	    	$(this).attr('disabled', false);
	    	$(this).removeClass('button_active');
	        return false; 
	    } 

	    // 验证码
	    var code  = $("input[name=register_code]").val();
	    if(code == ""){
	    	$.toptip('验证码有误', 'error');
	    	//$.toast("", "forbidden");
	    	$(this).html("立即注册");
	    	$(this).attr('disabled', false);
	    	$(this).removeClass('button_active');
	        return false; 
	    }

	    // 密码
	    var password = $("input[name=register_password]").val();
	    if(!(/^(\w){6,20}$/.exec(password))){
	    	$.toptip('密码格式不正确', 'error');
	    	//$.toast("", "forbidden");
	    	$(this).html("立即注册");
	    	$(this).attr('disabled', false);
	    	$(this).removeClass('button_active');
	        return false; 
	    }

	    // 确认密码
	    var confirm_password = $("input[name=register_confirm_password]").val();
	    if(password != confirm_password){
	    	$.toptip('两次密码不一致', 'error');
	    	//$.toast("", "forbidden");
	    	$(this).html("立即注册");
	    	$(this).attr('disabled', false);
	    	$(this).removeClass('button_active');
	        return false; 	
	    }

	    $.showLoading();

	    $("#register_form").submit();
	});


	// 获取验证码
	$(".weui-vcode-btn").click(function(){

		var count = 60;
		var This = this;
        this.disabled = true;
        var ThisObj = $(this);
        $(this).addClass("SendButton");

		var phone = $("input[name=register_phone]").val();

	    if(!(/^1[3456789]\d{9}$/.test(phone))){
	    	$.toptip('手机号码有误', 'error');
            //clearInterval(timer);
            This.disabled = false;
            This.innerHTML = '发送验证码';
            ThisObj.removeClass("SendButton");
            count = 60;
	        return false; 
	    } 

		$.ajax({
			url: '/getCode',
			type: 'post',
			data: {phone: phone},
			dataType: 'json',
			success:function(data){
				// 发送成功
				if(data.code == 10000){
					$.toptip('发送成功', 'success');
					this.innerHTML = "再次发送("+count + 's)';
			        var timer = setInterval(function(){
			            count--;   
			            if(count===-1){
			                clearInterval(timer);
			                This.disabled = false;
			                This.innerHTML = '发送验证码';
			                ThisObj.removeClass("SendButton");
			                count = 10;
			            }
			            else{
			                This.innerHTML = "再次发送("+count + 's)';
			            }
			        },1000);
				}else{
					$.toptip(data.message, 'error');
	                clearInterval(timer);
	                This.disabled = false;
	                This.innerHTML = '发送验证码';
	                ThisObj.removeClass("SendButton");
	                count = 10;
				}

			}
		});
	})
});

