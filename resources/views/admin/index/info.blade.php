@extends('layouts.admin')

@section('content')

    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}" target="_parent">首页</a> / 系统信息
    </div>
    <!--面包屑导航 结束-->

    <!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>快捷操作</h3>
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/article')}}" class="btn4"><i class="fa fa-recycle"></i>全部文章</a>
                <a href="{{url('admin/category')}}" class="btn5"><i class="fa fa-recycle"></i>全部分类</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->


    <div class="result_wrap">
        <div class="result_title">
            <h3>系统基本信息</h3>
        </div>
        <div class="result_content">
            <ul>
                <li>
                    <label>操作系统</label><span><?php echo  php_uname(); ?></span>
                </li>
                <li>
                    <label>运行环境</label><span><?php echo $_SERVER['SERVER_SOFTWARE']; ?></span>
                </li>
                <li>
                    <label>PHP版本</label><span><?php  echo PHP_VERSION; ?></span>
                </li>
                <li>
                    <label>网站版本</label><span>v-0.1</span>
                </li>
                <li>
                    <label>上传附件限制</label><span><?php echo (($max = get_cfg_var('upload_max_filesize')) ? $max : '不允许上传附件');?></span>
                </li>
                <li>
                    <label>北京时间</label><span><?php echo date('Y-m-d H:i:s', time()); ?></span>
                </li>
                <li>
                    <label>服务器域名/IP</label><span><?php echo $_SERVER['SERVER_ADDR']; ?></span>
                </li>
                <li>
                    <label>Host</label><span><?php echo $_SERVER['SERVER_ADDR']; ?></span>
                </li>
            </ul>
        </div>
    </div>
    <!--结果集列表组件 结束-->

@endsection
