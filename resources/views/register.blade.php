@extends('layouts.apps')

@section('css')
<style type="text/css">
.weui-icon_toast.weui-loading{margin: .8rem 0 0;}

.weui-toast{width: 6rem; height: 5.5rem; min-height: 5.5rem; top: 33%; left: 45%}

.weui-icon_toast{font-size: 2rem; margin-bottom: .6rem}

.weui-toast_content{ font-size: .7rem; }
</style>
@endsection

@section('content')

<header class="demos-header">
    <h1 class="demos-title">代理注册</h1>
</header>

<form action="" method="post" name="register" id="register_form">
@csrf
<div class="weui-cells weui-cells_form">

    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">手机号</label></div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="tel" placeholder="请输入手机号(账号)" name="register_phone" 
                value="{{old('register_phone')}}">
        </div>
    </div>


    <div class="weui-cell weui-cell_vcode">
        <div class="weui-cell__hd">
            <label class="weui-label">验证码</label>
        </div>

        <div class="weui-cell__bd">
            <input class="weui-input" type="number" placeholder="请输入验证码" name="register_code">
        </div>

        <div class="weui-cell__ft">
            <button class="weui-vcode-btn" type="button">发送验证码</button>
        </div>
    </div>


    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">密 码</label></div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="password" placeholder="由6-20位字母+数字组成" name="register_password">
        </div>
    </div>

    <!-- <div class="weui-cells__tips">密码由6-20位字母+数字组成</div> -->

    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">确认密码</label></div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="password" placeholder="请再次输入密码" name="register_confirm_password">
        </div>
    </div>

</div>

<!-- <div class="weui-cells__tips">请牢记您的注册信息</div> -->

<label for="weuiAgree" class="weui-agree">
      <input id="weuiAgree" type="checkbox" class="weui-agree__checkbox">
      <span class="weui-agree__text">
        阅读并同意<a href="javascript:void(0);">{{ config('app.name', 'Laravel') }}《相关条款》</a>
      </span>
</label>


<div class="weui-btn-area">
    <button class="weui-btn weui-btn_primary" id="Register">立即注册</button>
   
</div>

</form>
@endsection

@section('javascript')
<script type="text/javascript">
@if(count($errors) > 0)
    $.toptip('{{ $errors->first() }}', 'error');
@endif
</script>
@endsection

