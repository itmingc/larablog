@extends('layouts.admin')

@section('content')
<!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="#">首页</a> / 文章列表
</div>
<!--面包屑导航 结束-->

<!--搜索结果页面 列表 开始-->
<form action="#" method="post">
    <div class="result_wrap">
        <div class="result_title">
            <h3>全部文章</h3>
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

    <div class="result_wrap">
        <div class="result_content">
            <table class="list_tab customize-table">
                <tr>
                    <th class="tc" width='3%'>ID</th>
                    <th width='15%'>标题</th>
					<th width='7%'>作者</th>
					<th width='5%'>缩略图</th>
                    <th width='9%'>标签</th>
                    <th width='40%'>描述</th>
                    <th width='11%'>发布时间</th>
                    <th width='10%'>操作</th>
                </tr>
				@foreach($article as $v)
	                <tr>
	                    <td class="tc">{{$v->id}}</td>
	                    <td class="tc">{{$v->title}}</td>
	                    <td>{{$v->author}}</td>
	                    <td>
	                    	<img src="{{url($v->thumb)}}" alt="缩略图" style="max-width: 100px; max-height: 60px;">
	                    </td>
	                    <td>
                            @foreach($v->tags as $key => $value)
                                {{$value->name}} @if($key != count($v->tags) - 1),@endif
                            @endforeach
                        </td>
	                    <td class="description">{{$v->description}}</td>
	                    <td>{{date('Y-m-d H:i:s', $v->time)}}</td>
	                    <td>
	                        <a href="{{url('admin/article/' . $v->id . '/edit')}}" class="btn1">修改</a>
	                        <a href="javascript: void(0);" class="del btn3" target-id='{{$v->id}}'>删除</a>
	                    </td>
	                </tr>
                @endforeach
            </table>

            <div class="page_list">
                {{$article->links()}}
            </div>
        </div>
    </div>
</form>
<!--搜索结果页面 列表 结束-->
<style media="screen">
	table.list_tab tr th, table.list_tab tr td{padding: 2px; line-height: 1.8;}
    .page_list{text-align: center; margin: 10px auto ;}
    .page_list .pagination  li{ padding: 2px 5px; border: 1px solid #dcfffe;}
    .page_list .pagination span{ padding:0 10px;}
</style>
<script type="text/javascript">
    $(function () {
        // 删除操作弹窗确认
        $('.del').on('click', function(){
            $this = $(this);
            layer.confirm('确认删除？', {
              btn: ['是哒','放弃'] //按钮
            }, function(){
                var id = $this.attr('target-id');

                $.post('{{url("admin/article")}}/' + id, {
                    _method: 'DELETE',
                    _token: '{{csrf_token()}}'
                }, function(status){
                    if(status == 0){
                        layer.msg('删除成功', {icon: 6});
                        window.setTimeout(function(){
                            location.reload();
                        }, 1000);
                    }
                    else{
                        layer.msg('删除失败，请重试...', {icon: 5});
                    }

                });
            });

        });
    })
</script>
@endsection
