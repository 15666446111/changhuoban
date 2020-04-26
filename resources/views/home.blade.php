@extends('layouts.app')

@section('title')
首页
@endsection

@section('css')
<style type="text/css">
    html,body{background: #fafafa}
    .swiper-slide img{width: 100%;}
    .gg{height: 2rem; width: 95%;  border-radius: 5px; margin: 0 auto; background: white; box-shadow:#d3d3d3 0 0 4px 0;}
    .gg_left{float: left; width: 17%; color:#fe695a; height: 100%; text-align: center; line-height: 2rem;}
    .gg_right{width: 82%; float: left; line-height: 2rem; padding-left: 1%;}
    .gg_right a{font-size: .7rem}
    .weui-grids{width: 95%; height: auto; background: white; box-shadow:#d3d3d3 0 0 2px 0; border-radius: 5px; margin: 1rem auto 0rem auto;}
    .weui-grid{width: 25%; padding: 10px 10px;}
    .weui-grid__icon{width: 40px; height: 40px;}
    .weui-grids:before{border-top:none;}
    .weui-grids:after{border-left: none;}
    .weui-grid:before{border-right: none;}
    .weui-grid:after{border-bottom: none;}
    .trade{ margin: .5rem auto .5rem auto; width: 85%; padding:0 5%;}
    .trade .weui-grid{width: 50%;}
    .trade .weui-grid__icon{width: 100%; text-align: center;}
    .trade .weui-grid:after{border-bottom: 1px solid #d9d9d9;}
    .trade .weui-grid:before{border-left: 1px solid #d9d9d9;}
    .trade .weui-grid:nth-child(2n+0):before{ border-left: none}
    .primary{color:#fe695a;}
    .default{color:#f98021;}
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
        <div class="weui-grid__icon"><img src="{{ asset('images/icon_1.png') }}?time={{ time() }}" alt=""></div>
        <p class="weui-grid__label">商户注册</p>
    </a>
    <a href="" class="weui-grid js_grid">
        <div class="weui-grid__icon"><img src="{{ asset('images/icon_2.png') }}?time={{ time() }}" alt=""></div>
        <p class="weui-grid__label">商户登记</p>
    </a>
    <a href="" class="weui-grid js_grid">
        <div class="weui-grid__icon"><img src="{{ asset('images/icon_3.png') }}?time={{ time() }}" alt=""></div>
        <p class="weui-grid__label">商户管理</p>
    </a>
    <a href="" class="weui-grid js_grid">
        <div class="weui-grid__icon"><img src="{{ asset('images/icon_4.png') }}?time={{ time() }}" alt=""></div>
        <p class="weui-grid__label">在线客服</p>
    </a>
    <a href="" class="weui-grid js_grid">
        <div class="weui-grid__icon"><img src="{{ asset('images/icon_5.png') }}?time={{ time() }}" alt=""></div>
        <p class="weui-grid__label">商城购买</p>
    </a>
    <a href="" class="weui-grid js_grid">
        <div class="weui-grid__icon"><img src="{{ asset('images/icon_6.png') }}?time={{ time() }}" alt=""></div>
        <p class="weui-grid__label">团队扩展</p>
    </a>
    <a href="" class="weui-grid js_grid">
        <div class="weui-grid__icon"><img src="{{ asset('images/icon_7.png') }}?time={{ time() }}" alt=""></div>
        <p class="weui-grid__label">伙伴管理</p>
    </a>
    <a href="" class="weui-grid js_grid">
        <div class="weui-grid__icon"><img src="{{ asset('images/icon_8.png') }}?time={{ time() }}" alt=""></div>
        <p class="weui-grid__label">机具管理</p>
    </a>
</div>

<div class="weui-grids trade">
    <a href="javascript:;" class="weui-grid js_grid">
        <div class="weui-grid__icon primary">{{ number_format("2342000",2,".",",") }}</div>
        <p class="weui-grid__label">月交易额</p>
    </a>
    <a href="javascript:;" class="weui-grid js_grid">
        <div class="weui-grid__icon primary">{{ number_format("1002130", 2,".",",") }}</div>
        <p class="weui-grid__label">本月收益</p>
    </a>
    <a href="javascript:;" class="weui-grid js_grid">
        <div class="weui-grid__icon default">{{ number_format("1000000") }}</div>
        <p class="weui-grid__label">新增伙伴(人)</p>
    </a>
    <a href="javascript:;" class="weui-grid js_grid">
        <div class="weui-grid__icon default">{{ number_format("10000") }}</div>
        <p class="weui-grid__label">新增商户(户)</p>
    </a>
</div>


<div class="weui-tab">
    <div class="weui-tabbar">

        <a href="javascript:;" class="weui-tabbar__item weui-bar__item--on">
            <div class="weui-tabbar__icon"><i class="fa fa-home"></i></div>
            <p class="weui-tabbar__label">首页</p>
        </a>

        <a href="javascript:;" class="weui-tabbar__item">
            <div class="weui-tabbar__icon"><i class="fa fa-user-plus"></i></div>
            <p class="weui-tabbar__label">团队</p>
        </a>

        <a href="javascript:;" class="weui-tabbar__item">
            <span class="weui-badge" style="position: absolute;top: -.4em; right: 1rem;">8</span>
            <div class="weui-tabbar__icon"><i class="fa fa-heartbeat"></i></div>
            <p class="weui-tabbar__label">收益</p>
        </a>

        <a href="javascript:;" class="weui-tabbar__item">
            <span class="weui-badge" style="position: absolute;top: -.4em; right: 1rem;">8</span>
            <div class="weui-tabbar__icon"><i class="fa fa-user"></i></div>
            <p class="weui-tabbar__label">我的</p>
        </a>
    </div>
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
