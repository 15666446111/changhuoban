<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    
    @if(!is_null($favicon = Admin::favicon()))
    <link rel="shortcut icon" href="{{$favicon}}">
    @endif

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>{{config('admin.title')}} | {{ trans('admin.login') }}</title>

    <link rel="stylesheet" media="screen" href="{{ URL::asset('css/admin.css') }}" />

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <style>
        .dowebok {animation-delay: .5s;-webkit-animation-delay:.5s;}
    </style>
</head>

<body class="animated fadeIn">
    <div class="wrapper">

        <div class="top_wrapper">
            <div class="container">
                <div class="col-sm-12 header">
                    <a href="{{ admin_url('/') }}">
                        <img src="{{ URL::asset('images/login_logo.png') }}" width="140" height="37" class="retina" />
                    </a>
                </div>
            </div>
        </div>

        <div class="container">

            <div class="row">
                <div class="col-sm-12 login_content_wrapper">
                    <div class="content_wrapper">
                      
                        @if($errors->has('username'))
                        @foreach($errors->get('username') as $message)
                         <div id="messages" class="alert alert-danger animated fadeInUp dowebok">
                              <b>{{$message}}</b>
                         </div>
                        @endforeach
                        @endif


                        @if($errors->has('password'))
                        @foreach($errors->get('password') as $message)
                            <div id="messages" class="alert alert-danger animated fadeInUp dowebok">
                                <b>{{$message}}</b>
                            </div>
                        @endforeach
                        @endif

                        <h1 class="title">登录到您的{{config('admin.name')}}平台系统</h1>

                        <form action="{{ admin_url('auth/login') }}" method="post">
                            <div class="form-group">
                                <label class="Account">帐号:</label>
                                <input type="text" id="Account" class="form-control" autofocus="true" placeholder="{{ trans('admin.username') }}" name="username" value="{{ old('username') }}">
                            </div>

                            <div class="form-group" style="margin: 30px 0;">
                                <label class="Password">帐号:</label>
                                <input type="password" class="form-control" placeholder="{{ trans('admin.password') }}" name="password">
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <label class="remember" style="font-size:13px;font-weight:normal;">{{config('admin.name')}}</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-4 text-right">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn btn-primary btn-block btn-flat">{{ trans('admin.login') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> 
    <!-- jQuery 2.1.4 -->
    <script src="{{ admin_asset("vendor/laravel-admin/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js")}} "></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="{{ admin_asset("vendor/laravel-admin/AdminLTE/bootstrap/js/bootstrap.min.js")}}"></script>
    <!-- iCheck -->
    <script src="{{ admin_asset("vendor/laravel-admin/AdminLTE/plugins/iCheck/icheck.min.js")}}"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
</body>
</html>


