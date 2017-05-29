@extends('layouts.index')

@section('webconfig')
<meta name="keywords" content="{{$cate->keywords}}" />
<meta name="description" content="{{$cate->description}}" />
<title>{{$cate->name}} - {{config('web.web_title')}}</title>
@endsection

@section('css')
<style media="screen">
    .location{
        font-size: 14px;
    }
    .page {
        margin-top: 30px;
    }
</style>
@endsection

@section('primary')
<!-- 主内容 开始 -->
<div class="primary col-md-9 col-sm-12 col-xs-12">
    <section class="section">
        <div class="section-inner">
            <h2 class="heading page-header">
                <small class="location"><i class="fa fa-location-arrow"></i> 位置：<a href="{{url('/')}}">首页</a>
                    @foreach($cateTree as $v)
                        @if($v->id != $curId) / <a href="{{url('cate/' . $v->id)}}">{{$v->name}}</a> @else / {{$v->name}} @endif
                    @endforeach
                 </small>
            </h2>
            <div class="content">
                @foreach($data as $v)
                @if($v->thumb)
                <div class="per-item">
                    <div class="row">
                        <a class="col-md-4 col-sm-4 col-xs-12" href="{{url('a/' . $v->id)}}" target="_blank">
                            <img class="img-responsive project-image" src="{{url($v->thumb)}}" alt="{{$v->title}}" />
                        </a>
                        <div class="desc col-md-8 col-sm-8 col-xs-12">
                            <h3 class="title">
                                <a href="{{url('a/' . $v->id)}}" target="_blank">{{$v->title}}</a>
                            </h3>
                            <p class="postSummary">{{$v->description}}</p>
                            <p class="postDesc">
                                <span>{{date('Y-m-d H:i', $v->time)}}</span>
                                <span>编辑：{{$v->author}}</span>
                                <span>分类：<a href="{{url('cate/' . $v->cid)}}">{{$v->category->name}}</a></span>
                            </p>
                            <p class="readMore clearfix"><a class="btn btn-default pull-right" href="{{url('a/' . $v->id)}}">阅读全文</a></p>
                        </div><!--//desc-->
                    </div><!--//row-->
                </div>
                @else
                <!-- 无图 开始 -->
                <div class="per-item">
                    <div class="row">
                        <div class="desc col-md-12 col-sm-8 col-xs-12">
                            <h3 class="title">
                                <a href="{{url('a/' . $v->id)}}" target="_blank">{{$v->title}}</a>
                            </h3>
                            <p class="postSummary">{{$v->description}}</p>
                            <p class="postDesc">
                                <span>{{date('Y-m-d H:i', $v->time)}}</span>
                                <span>编辑：{{$v->author}}</span>
                                <span>分类：<a href="{{url('cate/' . $v->cid)}}">{{$v->category->name}}</a></span>
                            </p>
                            <p class="readMore clearfix"><a class="btn btn-default pull-right" href="{{url('a/' . $v->id)}}">阅读全文</a></p>
                        </div><!--//desc-->
                    </div><!--//row-->
                </div><!--//per-item-->
                <!-- 无图 结束 -->
                @endif
                @endforeach

                <!-- 分页 开始 -->
                <div class="page">
                    <div class="row">
                        <div class="col-md-12">
                    {!! with(new \App\Customer\Paginator\SimplePaginator($data))->render() !!}
                        </div>
                    </div>
                </div>
                <!-- 分页 结束 -->
            </div><!--//content-->
        </div>
    </section>
</div><!--//primary-->
<!-- 主内容 结束 -->
@endsection


<!-- 侧边栏 开始 -->
@section('secondary')
{{--
<!-- 其他分类 开始-->
<!--<aside class="aside section">
   <div class="section-inner">
       <h2 class="heading page-header">其他分类</h2>
       <div class="content">
           <ul class="list-unstyled">
               @foreach($otherCate as $v)
                  @if($v->id != $curId)
                      <li><i class="fa fa-folder-open"></i>&nbsp;&nbsp;<a href="{{url('cate/' . $v->id)}}">{{$v->name}}</a></li>
                  @endif
               @endforeach
           </ul>
       </div><
   </div><
</aside>--> <!--//aside-->
--}}
@parent
<!-- 其他分类 结束-->
@endsection
