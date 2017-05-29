<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('webconfig') {{-- 网站配置项：网页标题、关键字、描述等 --}}
    <link rel="shortcut icon" href="{{asset('index/assets/images/favicon.ico')}}">
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,300italic,400italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{asset('index/assets/plugins/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('index/assets/plugins/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('index/assets/plugins/bootsnav/css/bootsnav.css')}}">
    <link id="theme-style" rel="stylesheet" href="{{asset('index/assets/css/public.css')}}">

    @yield('css')
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <!-- 顶部导航条 开始-->
    <nav class="navbar navbar-default bootsnav on no-full">

        <!-- Start Top Search -->
        <div class="top-search">
            <div class="container">
                <form class="" action="{{url('q')}}" method="get" id="search-form">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-search"></i></span>
                        <input type="text" class="form-control" name="kw" placeholder="搜索关键词...">
                        <span class="input-group-addon close-search"><i class="fa fa-times"></i></span>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Top Search -->

        <div class="container">
            <!-- Start Atribute Navigation -->
            <div class="attr-nav">
                <ul>
                    <li class="search"><a href="#"><i class="fa fa-search" id="search"></i></a></li>
                    <li class="side-menu"><a href="#"><i class="fa fa-bars"></i></a></li>
                </ul>
            </div>
            <!-- End Atribute Navigation -->

            <!-- Start Header Navigation -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="{{url('/')}}"><img src="{{asset('index/assets/images/logo.png')}}" alt=""></a>
            </div>
            <!-- End Header Navigation -->

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-menu">
                <ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">
                    <li class=""><a href="{{url('/')}}">首页</a></li>
                    @foreach($topCate as $v)
                        <li><a href="{{url('cate/' . $v->id)}}" title="{{$v->title}}">{{$v->name}}</a></li>
                    @endforeach
                </ul>
            </div><!-- /.navbar-collapse -->
        </div>

        <!-- Start Side Menu -->
        <div class="side">
            <a href="#" class="close-side"><i class="fa fa-times"></i></a>
            <div class="widget">
                <h6 class="title">分类排行</h6>
                <ul class="link">
                    @foreach($cateRank as $v)
                        <li><a href="{{url('cate/' . $v->id)}}" title="{{$v->title ? $v->title : $v->name}}">{{$v->name}}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        <!-- End Side Menu -->
    </nav>
    <!-- 顶部导航条 结束-->

    <!--  Banner -->
    <div class="banner">
        <div class="container">
            <div class="row">
                <img class="profile-image img-responsive pull-left" src="{{asset('index/assets/images/profile.png')}}" alt="James Lee" />
                <div class="profile-content pull-left">
                    <h1 class="name">{{config('web.banner_title')}}</h1>
                    <h2 class="desc">{{config('web.banner_subtitle')}}</h2>
                    <ul class="social list-inline">
                        <li><a><i class="fa fa-twitter"></i></a></li>
                        <li><a><i class="fa fa-google-plus"></i></a></li>
                        <li><a><i class="fa fa-linkedin"></i></a></li>
                        <li><a><i class="fa fa-github-alt"></i></a></li>
                        <li class="last-item"><a><i class="fa fa-hacker-news"></i></a></li>
                    </ul>
                </div>
                <a class="btn btn-cta-primary pull-right" id='contact-me' href=""><i class="fa fa-paper-plane"></i> Contact Me</a>
            </div>
        </div>
    </div>
    <!--  Banner -->

    <!-- 主内容 和 侧边栏 开始 -->
    <div class="container sections-wrapper">
        <div class="row">
            @yield('primary')

            <div class="secondary col-md-3 col-sm-12 col-xs-12">
                @section('secondary')

                <!-- 热门标签 开始-->
                <aside class="aside section tag">
                    <div class="section-inner">
                        <h2 class="heading page-header">热门标签</h2>
                        <div class="content">
                            <ul class="list-inline">
                                <?php $class = ['label-default', 'label-primary', 'label-success', 'label-info', 'label-warning', 'label-danger'] ?>
                                @foreach($hotTag as $k => $v)
                                    <li><a href="{{url('tag/' . $v->id)}}"><span class="label {{$class[mt_rand(0, 5)]}}">{{$v->name}}</span></a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </aside>
                <!-- 热门标签 结束 -->

                <!-- 阅读排行榜 开始 -->
                 <aside class="aside section">
                    <div class="section-inner">
                        <h2 class="heading page-header">阅读排行榜</h2>
                        <div class="content">
                            <ul class="list-unstyled">
                                @foreach($readRank as $v)
                                    <li><i class="fa fa-file"></i>&nbsp;&nbsp;<a href="{{url('a/' . $v->id)}}" title="{{$v->title}}">{{$v->title}}</a></li>
                                @endforeach
                            </ul>
                        </div><!--//content-->
                    </div><!--//section-inner-->
                </aside><!--//aside-->
                <!-- 阅读排行榜 结束 -->

                <!-- 最新发布 开始 -->
                 <aside class="aside section">
                    <div class="section-inner">
                        <h2 class="heading page-header">最新发布</h2>
                        <div class="content">
                            <ul class="list-unstyled">
                                @foreach($newPub as $v)
                                    <li><i class="fa fa-file"></i>&nbsp;&nbsp;<a href="{{url('a/' . $v->id)}}" title="{{$v->title}}">{{$v->title}}</a></li>
                                @endforeach
                            </ul>
                        </div><!--//content-->
                    </div><!--//section-inner-->
                </aside><!--//aside-->
                <!-- 最新发布 结束 -->

                <!-- 随机推荐 开始 -->
                 <aside class="aside section">
                    <div class="section-inner">
                        <h2 class="heading page-header">随机推荐</h2>
                        <div class="content">
                            <ul class="list-unstyled">
                                @foreach($randRecommend as $v)
                                    <li><i class="fa fa-leaf"></i>&nbsp;&nbsp;<a href="{{url('a/' . $v->id)}}" title="{{$v->title}}">{{$v->title}}</a></li>
                                @endforeach
                            </ul>
                        </div><!--//content-->
                    </div><!--//section-inner-->
                </aside><!--//aside-->
                <!-- 随机推荐 结束 -->

                <!-- 友情链接 开始 -->
                 <aside class="aside section">
                    <div class="section-inner">
                        <h2 class="heading page-header">友情链接</h2>
                        <div class="content">
                            <ul class="list-unstyled">
                                @foreach($links as $v)
                                    <li><i class="fa fa-external-link-square"></i>&nbsp;&nbsp;<a href="{{$v->url}}" title="{{$v->title}}">{{$v->name}}</a></li>
                                @endforeach
                            </ul>
                        </div><!--//content-->
                    </div><!--//section-inner-->
                </aside><!--//aside-->
                <!-- 友情链接 结束 -->
                @show
            </div><!--//secondary-->
        </div><!--//row-->
    </div><!--//container-->
    <!-- 主内容 和 侧边栏 结束 -->

    <!-- 底部 开始 -->
    <footer class="footer">
        <div class="copyright">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-sm-12">
                        <h4>版权声明</h4>
                        <p>1. 本网站（网站地址）刊载的所有内容，包括文字、图片、音频、视频、软件、程序、以及网页版式设计等均在网上搜集。</p>
                        <p>2. 访问者可将本网站提供的内容或服务用于个人学习、研究或欣赏，以及其他非商业性或非盈利性用途，但同时应遵守著作权法及其他相关法律的规定，不得侵犯本网站及相关权利人的合法权利。除此以外，将本网站任何内容或服务用于其他用途时，须征得本网站及相关权利人的许可，并支付报酬。</p>
                        <p>3. 本网站内容原作者如不愿意在本网站刊登内容，请及时通知本站，予以删除。</p>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <h4>联系我</h4>
                        <p>如果您有任何关于本站的建议，或合作开发，版权协商等事宜，请联系我。</p>
                        <p>发送邮件时，请以"[{{config('web.domain')}}]"为主题前缀，造成的不便敬请谅解。</p>
                        <p>地址：{{config('web.address')}} </p>
                        <p>电话：{{config('web.phone')}} </p>
                        <p>邮箱：{{config('web.email')}}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p class="text-center">{{config('web.copyright')}} </p>
                    </div>
                </div>
            </div><!--//container-->
        </div>
    </footer><!--//footer-->
    <!-- 底部 结束 -->

    <!-- Javascript -->
    <script type="text/javascript" src="{{asset('index/assets/plugins/jquery-3.2.1.min.js')}}"  ></script>
    <script type="text/javascript" src="{{asset('index/assets/plugins/bootstrap/js/bootstrap.min.js')}}"  ></script>
    <script type="text/javascript" src="{{asset('index/assets/plugins/bootsnav/js/bootsnav.js')}}" ></script>
    <script type="text/javascript" src="{{asset('index/assets/js/public.js')}}" ></script>
    <script type="text/javascript" >
        $(function () {
            $('#search').on('click', function () {
                $('input[name="kw"]').focus();
            })
        })
    </script>
</body>
</html>
