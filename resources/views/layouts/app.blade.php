<!DOCTYPE HTML>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta http-equiv=Content-Type content=text/html; charset=utf-8 />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>

    <!-- head 中 -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/weui/1.1.3/style/weui.min.css">

    <link rel="stylesheet" href="https://cdn.bootcss.com/jquery-weui/1.2.1/css/jquery-weui.min.css">

    <link href="{{ asset('font-awesome/css/font-awesome.css') }}?t={{ time() }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('css/apps.css') }}?t={{ time() }}" rel="stylesheet" type="text/css" />
    
    <link rel="Bookmark" href="logo.ico">

    @yield('css')
</head>
<body>

    @yield('content')

    <!-- body 最后 -->
    <script src="https://cdn.bootcss.com/jquery/1.11.0/jquery.min.js"></script>

    <script src="https://cdn.bootcss.com/jquery-weui/1.2.1/js/jquery-weui.min.js"></script>

    <!-- DIY Javascript-->
    <script src="{{ asset('js/apps.js') }}?time={{ time() }}" defer></script>

    @yield('scripts')

</body>
</html>