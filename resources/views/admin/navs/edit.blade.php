@extends('layouts.admin')

@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> / 修改导航
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>修改导航</h3>
	        @if(count($errors) > 0)
	            @if(is_object($errors))
	                @foreach($errors->all() as $v)
	                    <p style="color: #ff6969;">{{$v}}</p>
	                @endforeach
	            @else
	                <p style="color: #ff6969;">{{$errors}}</p>
	            @endif
	        @endif
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/navs/create')}}" class="btn4"><i class="fa fa-plus"></i>添加导航</a>
                <a href="{{url('admin/navs')}}" class="btn5"><i class="fa fa-recycle"></i>全部导航</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

    <div class="result_wrap">
        <form action="{{url('admin/navs/'. $navs->id)}}" method="post" id="add-form">
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>导航名称：</th>
                        <td>
                            <input type="text" class="lg" name="name" value="{{$navs->name}}">
							<span><i class="fa fa-exclamation-circle yellow"></i>导航名称必须填写</span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>URL：</th>
                        <td>
                            <input type="text" name="url" value="{{$navs->url}}">
                            <i class="fa fa-exclamation-circle yellow"></i>导航URL必须填写</span>
                        </td>
                    </tr>
                    <tr>
                        <th>排序：</th>
                        <td>
                            <input type="text" name="sort" value="{{$navs->sort}}">
                        </td>
                    </tr>
                    <tr>
                        <th>&nbsp;</th>
                        <td>
                            <input type="hidden" name="_method" value="PUT">
							<input type="hidden" name="_token" value="{{csrf_token()}}">
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
@endsection
