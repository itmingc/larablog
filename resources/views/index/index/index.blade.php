@extends('layouts.index')

@section('webconfig')
<title>{{config('web.web_title')}} - {{config('web.seo_title')}}</title>
<meta name="keywords" content="{{config('web.keywords')}}" />
<meta name="description" content="{{config('web.description')}}" />
@endsection

@section('primary')
<!-- 主内容 开始 -->
<div class="primary col-md-9 col-sm-12 col-xs-12">
<section class="section">
    <div class="section-inner">
        <!-- 最新发布 开始 -->
        <h2 class="heading page-header">最新发布</h2>
        <div class="content">
            @foreach($new as $v)
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
                            <p class="postSummary blockquote">{{$v->description}}</p>
                            <p class="postDesc">
                                <span><i class="fa fa-"></i>{{date('Y-m-d H:i', $v->time)}}</span>
                                <span>编辑：{{$v->author}}</span>
                                <span>分类：<a href="{{url('cate/' . $v->cid)}}">{{$v->category->name}}</a></span>
                            </p>
                            <p class="readMore clearfix"><a class="btn btn-default pull-right" href="{{url('a/' . $v->id)}}">阅读全文</a></p>
                        </div><!--//desc-->
                    </div><!--//row-->
                </div><!--//content-->
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
                                <span>分类：<a href="{{url('cate/' . $v->cid)}}">{{$v->select('id', 'name')->category()->name}}</a></span>
                            </p>
                            <p class="readMore clearfix"><a class="btn btn-default pull-right" href="{{url('a/' . $v->id)}}">阅读全文</a></p>
                        </div><!--//desc-->
                    </div><!--//row-->
                </div><!--//per-item-->
                <!-- 无图 结束 -->
            @endif
            @endforeach
        </div>
        <!-- 最新发布 结束 -->

        <div class="page">
            <div class="row">
                <div class="col-md-12">
                    {!! with(new \App\Customer\Paginator\SimplePaginator($new))->render() !!}
                </div>
            </div>
        </div>

    </div>
</section>
</div><!--//primary-->
<!-- 主内容 结束 -->
@endsection
