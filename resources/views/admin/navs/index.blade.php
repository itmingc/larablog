@extends('layouts.admin')

@section('content')

    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> / 全部导航栏
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <div class="result_title">
                <h3>全部导航栏</h3>
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/navs/create')}}" class="btn4"><i class="fa fa-plus"></i>添加导航栏</a>
                    <a href="{{url('admin/navs')}}" class="btn5"><i class="fa fa-recycle"></i>全部导航栏</a>
                </div>
            <!--快捷导航 结束-->
            </div>
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">排序</th>
                        <th class="tc">ID</th>
                        <th>导航名称</th>
                        <th>URL</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                        <tr>
                            <td class="tc">
                                <input class="field_order" target-id='{{$v->id}}' type="text" name="sort" value="{{$v->sort}}" autocomplete="off">
                            </td>
                            <td class="tc">{{$v->id}}</td>
                            <td>{{$v->name}}</td>
                            <td>{{$v->url}}</td>
                            <td>
                                <a href="{{url('admin/navs/' . $v->id .'/edit' )}}" class="btn1">修改</a>
                                <a href="javascript: void(0); " class="del btn3" target-id="{{$v->id}}">删除</a>
                            </td>
                        </tr>
                    @endforeach

                </table>

            </div>

        </div>
    </form>
    <!--搜索结果页面 列表 结束-->

    <script type="text/javascript" charset="utf-8" async defer>
        $(function (){
            // 异步更新排序
            $('.field_order').on('change', function (){

                $.post('{{url("admin/navs/changesort")}}', {

                     _token : '{{csrf_token()}}',
                     id: parseInt($(this).attr('target-id')),
                     sort:  parseInt($(this).val())

                 }, function (status) {
                    if(status){ // ok
                        location.reload();
                        layer.msg('更新排序成功', {icon: 6});
                    }
                    else{ // no ok
                        layer.msg('更新排序失败', {icon: 5});
                    }
                 });
            });

            // 删除操作弹窗确认
            $('.del').on('click', function(){
                $this = $(this);
                layer.confirm('确认删除？', {
                  btn: ['是哒','放弃'] //按钮
                }, function(){
                    var id = $this.attr('target-id');

                    $.post('{{url("admin/navs")}}/' + id, {
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

        });
    </script>

@endsection
