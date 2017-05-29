@extends('layouts.admin')

@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> / 修改分类
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>修改分类</h3>
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
                <a href="{{url('admin/category/create')}}" class="btn4"><i class="fa fa-plus"></i>添加分类</a>
                <a href="{{url('admin/category')}}" class="btn5"><i class="fa fa-recycle"></i>全部分类</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

    <div class="result_wrap">
        <form action="{{url('admin/category/'. $category->id)}}" method="post" id="add-form">
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th width="120"><i class="require">*</i>父级分类：</th>
                        <td>
                            <select name="pid">
                                <option value="0"
                                 @if(0 == $category->pid)
                                    style="color:red; font-weight: bold;"
                                @endif
                                >顶级分类</option>
								@foreach($cateTree as $v)
	                                <option value="{{$v->id}}"
                                    @if($v->id == $category->pid)
                                        selected
                                    @endif
                                    @if($v->id == $category->pid)
                                        style="color:red; font-weight: bold;"
                                    @endif
                                    >
                                    @if($v->pid) &nbsp;&nbsp;|@endif{{$v->html}}{{$v->name}}
                                    </option>
								@endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>名称：</th>
                        <td>
                            <input type="text" name="name" value="{{$category->name}}"size="80">
							<span><i class="fa fa-exclamation-circle yellow"></i>分类名称必须填写</span>
                        </td>
                    </tr>
                    <tr>
                        <th>标题：</th>
                        <td>
                            <input type="text" name="title" value="{{$category->title}}" size="80"><span>关于这个分类的介绍</span>
                        </td>
                    </tr>
                    <tr>
                        <th>关键词：</th>
                        <td>
                            <input type="text" name="keywords" value="{{$category->keywords}}" size="80">
                            <span>这将显示在网页的&lt;meta&gt;头中</span>
                        </td>
                    </tr>
                    <tr>
                        <th>描述：</th>
                        <td>
                            <textarea name="description">{{$category->description}}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>排序：</th>
                        <td>
                            <input type="text" name="sort" value="{{$category->sort}}">
                        </td>
                    </tr>
                    <tr>
                        <th>查看次数：</th>
                        <td>
                            <input type="text" name="click" value='{{$category->click}}'>
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
