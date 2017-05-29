@extends('layouts.admin')

@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> / 添加文章
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>添加文章</h3>
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
                <a href="{{url('admin/article/create')}}" class="btn4"><i class="fa fa-plus"></i>添加文章</a>
                <a href="{{url('admin/article')}}" class="btn5"><i class="fa fa-recycle"></i>全部文章</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

    <div class="result_wrap">
        <form action="{{url('admin/article')}}" method="post" id="add-form">
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th width="120"><i class="require">*</i>所属分类：</th>
                        <td>
                            <select name="cid" id="cid">
                                <option value="0" selected>请选择一个分类</option>
                                @foreach($category as $v)
	                                <option value="{{$v->id}}">@if($v->pid) &nbsp;&nbsp;|@endif{{$v->html}}{{$v->name}}</option>
                                @endforeach
                            </select>
                            <span style="color: red"></span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>文章标题：</th>
                        <td>
                            <input type="text" class="lg" name="title"><span style="color: red"></span>
                        </td>
                    </tr>
                    <tr>
                        <th>作者：</th>
                        <td>
                            <input type="text" name="author" value="">
                        </td>
                    </tr>
                    <tr>
                        <th>缩略图：</th>
                        <td>
                            <input type="text" id="thumb" name="thumb" value="" readonly>
                            <input id="file_upload" name="file_upload" type="file">
                            <!-- <a href="javascript:$('#file_upload').uploadify('cancel')">取消第一个文件</a> | <a href="javascript:$('#file_upload').uploadify('cancel', '*');">清空队列</a> | <a href="javascript:$('#file_upload').uploadify('upload', '*');">确认上传</a> -->
                        </td>
                    </tr>
                    <tr id="img-tr" hidden>
                        <th>&nbsp;</th>
                        <td>
                            <img src="" alt="上传的图片" style="max-width: 300px; max-height: 120px;">
                        </td>
                    </tr>
                    <tr>
                        <th>标签：</th>
                        <td>
                            <input type="text" name="tag" size="60">
                            <span><i class="fa fa-exclamation-circle yellow"></i>多个标签之间以逗号分隔</span>
                        </td>
                    </tr>
                    <tr>
                        <th>描述：</th>
                        <td>
                            <input type="text" name="description" value="" size="90">
                        </td>
                    </tr>
                    <tr>
                        <th style="vertical-align: top;">文章内容：</th>
                        <td>
                            <textarea name="content" id="container"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>&nbsp;</th>
                        <td>
							{{csrf_field()}}
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>

<link rel="stylesheet" type="text/css" href="{{asset('org/uploadify/uploadify.css')}}">
<script src="{{asset('org/uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
<script type="text/javascript" charset="utf-8" src="{{asset('org/ueditor/ueditor.config.js')}}"></script>
<script type="text/javascript" charset="utf-8" src="{{asset('org/ueditor/ueditor.all.min.js')}}"> </script>
<script type="text/javascript" charset="utf-8" src="{{asset('org/ueditor/lang/zh-cn/zh-cn.js')}}"></script>
<script type="text/javascript">
    window.UEDITOR_CONFIG.initialFrameWidth = 1000; // 设置编辑器宽度
    window.UEDITOR_CONFIG.initialFrameHeight = 600; // 设置编辑器高度
    // window.UEDITOR_CONFIG.serverUrl = ""; // 服务器统一请求接口路径
    UE.getEditor('container'); // 实例化编辑器，container是要实例化的网页元素id

    $(function() {
        $('#add-form').submit(function() {
            var $cate = $('select[name="cid"]'),
                $title = $('input[name="title"]');

                $cate.next().html('');
                $title.next().html('');

                if($cate.val() == 0){
                    $cate.next().html('请选择一个分类');
                    $cate.focus();
                    return false;
                }
                if($title.val().trim() == ''){
                    $title.next().html('文章标题不能为空');
                    $title.focus();
                    return false;
                }

                return true;

        });
    	$('#file_upload').uploadify({
        	swf      : "{{asset('org/uploadify/uploadify.swf')}}", // 引入Uploadify 的核心Flash文件
            uploader : "{{url('admin/upload')}}", // PHP处理脚本的地址
            width: 120, // 上传按钮宽度
            height: 30, // 上传按钮高度
            buttonImage: "{{asset('org/uploadify/browse-btn.png')}}", // 上传按钮背景图片地址
            fileTypeDesc: 'Image File', // 选择文件对话框中图片类型提示文字
            fileTypeExts: '*.jpg;*.jpeg;*.png;*.gif', // 选择文件对话框中允许选择的文件类型
            formData     : {'_token': '{{csrf_token()}}'}, // Laravel表单提交必需参数_token，防止CSRF
            onUploadSuccess : function(file, data, response) { // 上传成功回调函数
                $('#img-tr').show().find('img').attr('src', data);
                $('#thumb').val(data);
            },
            onUploadError: function(file, errorCode, errorMsg, errorString) { // 上传失败回调函数
                $('#img-tr').hide().find('img').attr('src', '');
                layer.msg('上传失败，请重试');
            }
    	});
	});
</script>
<style media="screen">
    .uploadify {display: inline-block;}
    .uploadify-button {border: none; margin-top: 10px; border-radius: 12px; }
    .add_tab .uploadify-button-text {color : #eafcfc; }

    .edui-default {line-height: 28px;}
    div.edui-combox-body, div.edui-button-body, div.edui-splitbutton-body {overflow: hidden; height: 20px;}
    div.edui-box {overflow: hidden; height: 22px;}
</style>
@endsection
