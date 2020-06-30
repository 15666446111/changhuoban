<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- head 中 -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/weui/1.1.3/style/weui.min.css">

    <link rel="stylesheet" href="https://cdn.bootcss.com/jquery-weui/1.2.1/css/jquery-weui.min.css">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    
    <!-- DIY Css-->
    <link rel="stylesheet" href="{{ asset('css/apps.css') }}">

    @yield('css')
</head>

<body>

    @yield('content')

    <!-- body 最后 -->
    <script src="https://cdn.bootcss.com/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/jquery-weui/1.2.1/js/jquery-weui.min.js"></script>

    <!-- DIY Javascript-->
    <script src="{{ asset('js/apps.js') }}" defer></script>

    @yield('javascript')
</body>

</html>
