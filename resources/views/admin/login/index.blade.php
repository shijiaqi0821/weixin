<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <title>排版布局-展示</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->
    <link rel="shortcut icon" href="favicon.ico"> <link href="/static/admin/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="/static/admin/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">
    <link href="/static/admin/css/animate.css" rel="stylesheet">
    <link href="/static/admin/css/style.css?v=4.1.0" rel="stylesheet">
</head>
<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden">
    <div id="wrapper">
        <!--左侧导航开始-->
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="nav-close"><i class="fa fa-times-circle"></i>
            </div>
            <div class="sidebar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear">
                                    <span class="block m-t-xs" style="font-size:20px;">
                                        <i class="fa fa-area-chart"></i>
                                        <strong class="font-bold">hAdmin</strong>
                                    </span>
                                </span>
                            </a>
                        </div>
                        <div class="logo-element">hAdmin
                        </div>
                    </li>
                    <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                        <span class="ng-scope">分类</span>
                    </li>
                    <li>
                        <a class="J_menuItem" href="{{url('login/show')}}">
                            <i class="fa fa-home"></i>
                            <span class="nav-label">主页</span>
                        </a>
                    </li>
                    <li>
                        <a class="J_menuItem" href="{{url('/weather/create')}}">
                            <i class="fa fa-flask"></i>
                            <span class="nav-label">天气</span>
                        </a>
                    </li>
                    <li>
                        <a class="J_menuItem" href="{{url('/wechat/mass')}}">
                            <i class="fa fa-flask"></i>
                            <span class="nav-label">群发</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa fa-bar-chart-o"></i>
                            <span class="nav-label">素材管理</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a class="J_menuItem" href="{{url('/material/create')}}">素材添加</a>
                            </li>
                            <li>
                                <a class="J_menuItem" href="{{url('/material')}}">素材展示</a>
                            </li>
                        </ul>
                    </li>
            {{--====================================================================================================--}}
                    <li>
                        <a href="#">
                            <i class="fa fa fa-edit"></i>
                            <span class="nav-label">渠道管理</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a class="J_menuItem" href="{{url('/quick/create')}}">渠道添加</a>
                            </li>
                            <li>
                                <a class="J_menuItem" href="{{url('/quick')}}">渠道展示</a>
                            </li>
                            <li>
                                <a class="J_menuItem" href="{{url('/quick/graph')}}">图形展示</a>
                            </li>
                        </ul>
                {{--================================================================================================--}}

                    </li>
                    <li class="line dk"></li>
                </ul>
            </div>
        </nav>
        <!--左侧导航结束-->
        <!--右侧部分开始-->
        <div id="page-wrapper" class="gray-bg dashbard-1">
            <div class="row border-bottom">
                <a class="navbar-minimalize minimalize-styl-2 btn btn-info " href="#">
                    <i class="fa fa-bars"> 收缩导航栏</i>
                </a>
            </div>

            <div class="row J_mainContent" id="content-main">
                <iframe id="J_iframe" width="100%" height="100%" src="{{url('login/show')}}" frameborder="0" data-id="index_v1.html" seamless></iframe>
            </div>
        </div>
        <!--右侧部分结束-->
    </div>
    <!-- 全局js -->
    <script src="/static/admin/js/jquery.min.js?v=2.1.4"></script>
    <script src="/static/admin/js/bootstrap.min.js?v=3.3.6"></script>
    <script src="/static/admin/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="/static/admin/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="/static/admin/js/plugins/layer/layer.min.js"></script>
    <!-- 自定义js -->
    <script src="/static/admin/js/hAdmin.js?v=4.1.0"></script>
    <script type="text/javascript" src="/static/admin/js/index.js"></script>
    <!-- 第三方插件 -->
    <script src="/static/admin/js/plugins/pace/pace.min.js"></script>
</body>
</html>
