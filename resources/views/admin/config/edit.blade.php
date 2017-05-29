@extends('layouts.admin')

@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> / 修改配置项
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>修改配置项</h3>
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
                <a href="{{url('admin/config/create')}}" class="btn4"><i class="fa fa-plus"></i>添加配置项</a>
                <a href="{{url('admin/config')}}" class="btn5"><i class="fa fa-recycle"></i>全部配置项</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

    <div class="result_wrap">
        <form action="{{url('admin/config/' . $config->id)}}" method="post" id="add-form">
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>标题：</th>
                        <td>
                            <input type="text" name="title" value="{{$config->title}}" >
							<span><i class="fa fa-exclamation-circle yellow"></i>配置项标题必须填写</span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>名称：</th>
                        <td>
                            <input type="text" name="name" value="{{$config->name}}">
							<span><i class="fa fa-exclamation-circle yellow"></i>配置项名称必须填写</span>
                        </td>
                    </tr>
                    <tr>
                        <th>类型：</th>
                        <td>
                            <input type="radio" name="fieldtype" value="input" @if($config->fieldtype == 'input') checked @endif>单行文本框&nbsp;&nbsp;
                            <input type="radio" name="fieldtype" value="textarea" @if($config->fieldtype == 'textarea') checked @endif>多行文本框&nbsp;&nbsp;
                            <input type="radio" name="fieldtype" value="radio" @if($config->fieldtype == 'radio') checked @endif>单选框
                        </td>
                    </tr>
                    <tr>
                        <th>类型值：</th>
                        <td>
                            <input type="text" name="fieldvalue" value="{{$config->fieldvalue}}"><span style="padding-left: 20px; color: rgb(255, 75, 75);"></span>
                            <p><i class="fa fa-exclamation-circle yellow"></i>只有在“类型” 选项为“radio” 时，该项需配置。格式：<sapn style="color: red;">1|开启,0|关闭</span></p>
                        </td>
                    </tr>
                    <tr>
                        <th>排序：</th>
                        <td>
                            <input type="text" name="sort" value="{{$config->sort}}">
                        </td>
                    </tr>
                    <tr>
                        <th>说明：</th>
                        <td><textarea name="tips">{{$config->tips}}</textarea></td>
                    </tr>
                    <tr>
                        <th></th>
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
    <script type="text/javascript">
        $(function (){
            // 提交时如果选择类型为 radio 且 类型值不符合格式时提示用户
            $('#add-form').submit(function () {
                var $obj = $('input[name="fieldvalue"]');
                var val = $obj.val().trim();

                if($('input:radio[name="fieldtype"]:checked').val() == 'radio'
                 && !/^1\|[\u4e00-\u9fa5]+,0\|[\u4e00-\u9fa5]+$/.test(val)){
                    $obj.next().html('请按照格式输入：1|开启,0|关闭');
                    return false;
                }
                else{
                    $obj.next().html('');
                    return true;
                }
            });

            // 默认隐藏类型值所在的行
            var $tr = $('input[name="fieldvalue"]').parents('tr');
            if($('input:radio[name="fieldtype"]:checked').val() != 'radio'){
                $tr.hide();
            }

            // 选中类型为 radio 时，显示类型值所在的行
            $('input:radio[name="fieldtype"]').click(function () {
                if($('input:radio[name="fieldtype"]:checked').val() == 'radio'){
                    $tr.show();
                }
                else{
                    $tr.hide();
                }
            });

        });
    </script>
@endsection
