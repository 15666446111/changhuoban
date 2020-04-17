@extends('layouts.app')

@section('title')
找回密码
@endsection

@section('css')
<style type="text/css">
    .weui-cells:before{border-top:none;}
    .weui-cells{width: 80%; margin: 0 auto;}
    .weui-cell__hd{width: 10%;}
    i{font-size: 1.3rem!important; color: #fe695a;}
    .fa-mobile-phone{font-size: 1.6rem!important}
    input{font-size: .7rem!important;}
    .weui-cell:after{border-bottom: 1px solid #ccc, content: " "; height: 1px; position: absolute; left: 0; top: 0}
    .weui-agree{padding-top:1rem; padding-bottom: 1rem}

    .login_button{background: #fe695a }
    .weui-vcode-btn{font-size: .65rem; color: #fe695a;}
</style>

@endsection

@section('content')
    <div class="logo_box">
        <img src="{{ asset('images/logo.png') }}?t={{ time() }}">
    </div>

    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label"><i class="fa fa-mobile-phone"></i></label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" type="tel" pattern="[0-9]*" placeholder="请输入手机号" autocomplete="new-password">
            </div>
        </div>

        <div class="weui-cell weui-cell_vcode">
            <div class="weui-cell__hd">
                <label class="weui-label"><i class="fa fa-shield"></i></label>
            </div>
            <div class="weui-cell__bd">
                <input class="weui-input" type="tel" pattern="[0-9]*" placeholder="请输入验证码">
            </div>
            <div class="weui-cell__ft">
                <button class="weui-vcode-btn">获取验证码</button>
            </div>
        </div>

        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label"><i class="fa fa-lock"></i></label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" type="password" placeholder="请输入您的密码" autocomplete="new-password">
            </div>
        </div>

        <label for="weuiAgree" class="weui-agree">
            <span class="weui-agree__text"><a href="/" style="float: right;">立即登录?</a></span>
        </label>

        <button class="weui-btn weui-btn_primary login_button" href="javascript:" id="Forget">立即找回</button>
    </div>
@endsection

