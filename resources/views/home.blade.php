@extends('layouts.app')

@section('title')
首页
@endsection

@section('css')
<style type="text/css">
    html,body{background: #fafafa}
    .swiper-slide img{width: 100%;}
    .gg{height: 2rem; width: 95%;  border-radius: 5px; margin: 0 auto; background: white; box-shadow:#d3d3d3 0 0 4px 0;}
    .gg_left{float: left; width: 10%; color:#fe695a; height: 100%; text-align: center; line-height: 2rem;}
    .gg_right{width: 87%; float: left; line-height: 2rem; padding-left: 3%;}
    .gg_right a{font-size: .85rem}
    .weui-grids{width: 95%; height: auto; background: white; box-shadow:#d3d3d3 0 0 3px 0; border-radius: 5px; margin: 1rem auto;}
    .weui-grid{width: 25%;}
</style>
@endsection

@section('content')
<div class="swiper-container">
    <div class="swiper-wrapper">
        <div class="swiper-slide">
            <img src="//gj.changhuoban.com/public/upload/admin/20200330/38ec7da12c3e36997a0189c180596f93.png" alt="">
        </div>
        <div class="swiper-slide">
            <img src="//gj.changhuoban.com/public/upload/admin/20200330/38ec7da12c3e36997a0189c180596f93.png" alt="">
        </div>
        <div class="swiper-slide">
            <img src="//gj.changhuoban.com/public/upload/admin/20200330/38ec7da12c3e36997a0189c180596f93.png" alt="">
        </div>
    </div>
</div>

<div class="gg">
    <div class="gg_left"><i class="fa fa-volume-up"></i></div>
    <div class="gg_right">
        <a href="">畅伙伴3.0上线啦！！！</a>
    </div>
</div>

<div class="weui-grids">
    <a href="" class="weui-grid js_grid">
        <div class="weui-grid__icon">
            <img src="images/icon_nav_button.png" alt="">
        </div>
        <p class="weui-grid__label">商户注册</p>
    </a>
    <a href="" class="weui-grid js_grid">
        <div class="weui-grid__icon">
            <img src="images/icon_nav_cell.png" alt="">
        </div>
        <p class="weui-grid__label">商户登记</p>
    </a>
    <a href="" class="weui-grid js_grid">
        <div class="weui-grid__icon">
            <img src="images/icon_nav_cell.png" alt="">
        </div>
        <p class="weui-grid__label">商户管理</p>
    </a>
    <a href="" class="weui-grid js_grid">
        <div class="weui-grid__icon">
            <img src="images/icon_nav_cell.png" alt="">
        </div>
        <p class="weui-grid__label">在线客服</p>
    </a>
</div>
@endsection


@section('scripts')
<script src="https://cdn.bootcss.com/jquery-weui/1.2.1/js/swiper.min.js"></script>
<script type="text/javascript">
$(".swiper-container").swiper({
    loop: true,
    autoplay: 1000
});
</script>
@endsection
