@extends('layouts.show')
@section('title', '排版布局-登录')
@section('content')

    <link href="/static/admin/css/font-awesome.css?v=4.4.0" rel="stylesheet">
    <link href="/static/admin/css/animate.css" rel="stylesheet">
    <link href="/static/admin/css/style.css?v=4.1.0" rel="stylesheet">
    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->
    <script>if(window.top !== window.self){ window.top.location = window.location;}</script>

    <div class="middle-box text-center loginscreen  animated fadeInDown">
        <div>
            <div><h1 class="logo-name">h</h1></div>
            <h3>欢迎使用 hAdmin</h3>

            <form class="m-t" role="form" action="{{url('/login/store')}}" method="post">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control"name="name" placeholder="用户名" required="">
                    <b style="color: #9d0006 ">{{$errors->first('name')}}</b>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="pwd" placeholder="密码" required="">
                    <b style="color: #9d0006 ">{{$errors->first('pwd')}}</b>
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">登 录</button>


                <p class="text-muted text-center"> <a href="login.html#"><small>忘记密码了？</small></a> | <a href="register.html">注册一个新账号</a>
                </p>

            </form>
        </div>
    </div>
@endsection