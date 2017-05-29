@extends('layouts.index')

@section('webconfig')
<meta name="keywords" content="{{$kw}}" />
<meta name="description" content="{{$kw}}" />
<title>{{$kw}} - {{config('web.web_title')}}</title>
@endsection

@section('css')
<style media="screen">
    .section .heading i{
        color: #f4645f;
    }
    .section .heading .badge{
        /*font-size: 24px;*/
    }
</style>
@endsection

@section('primary')
<!-- 主内容 开始 -->
<div class="primary col-md-9 col-sm-12 col-xs-12">
    <section class="section">
        <div class="section-inner">
            <h2 class="heading page-header"><i class="fa fa-quote-left"></i>&nbsp;{{$kw}}&nbsp;<small><span class="badge">{{count($article)}}</span>个相关结果</small></h2>
            <div class="content hot">
                <div class="row">
                    <div class="col-md-12">
                        @foreach($article as $v)
                            @if($v->thumb)
                                <!-- 开始-->
                                <div class="per-item">
                                    <div class="row">
                                        <a class="col-md-4 col-sm-4 col-xs-12" href="{{url('a/' . $v->id)}}">
                                            <img class="img-responsive project-image" src="{{url($v->thumb)}}" alt="{{$v->title}}" />
                                        </a>
                                        <div class="desc col-md-8 col-sm-8 col-xs-12">
                                            <h3 class="title">
                                                <a href="{{url('a/' . $v->id)}}">{{$v->title}}</a>
                                            </h3>
                                            <p class="postSummary">{{$v->description}}</p>
                                            <p class="postDesc">
                                                <span>{{date('Y-m-d H:i', $v->time)}}</span>
                                                <span>编辑：{{$v->author}}</span>
                                                <span>分类：<a href="">{{$v->category->name}}</a></span>
                                            </p>
                                            <p class="readMore clearfix"><a class="btn btn-default pull-right" href="{{url('a/' . $v->id)}}">阅读全文</a></p>
                                        </div><!--//desc-->
                                    </div><!--//row-->
                                </div><!--//item-->
                                <!-- 结束 -->
                            @else
                                <!-- 无图 开始 -->
                                <div class="per-item">
                                    <div class="row">
                                        <div class="desc col-md-12 col-sm-12 col-xs-12">
                                            <h3 class="title">
                                                <a href="{{url('a/' . $v->id)}}">{{$v->title}}</a>
                                            </h3>
                                            <p class="postSummary">{{$v->description}}</p>
                                            <p class="postDesc">
                                                <span>{{date('Y-m-d H:i', $v->time)}}</span>
                                                <span>编辑：{{$v->author}}</span>
                                                <span>分类：<a href="">{{$v->category->name}}</a></span>
                                            </p>
                                            <p class="readMore clearfix"><a class="btn btn-default pull-right" href="{{url('a/' . $v->id)}}">阅读全文</a></p>
                                        </div>
                                    </div><!--//row-->
                                </div><!--//per-item-->
                                <!-- 无图 结束 -->
                            @endif
                        @endforeach

                        <!-- 分页 开始 -->
                        <div class="page">
                            <div class="row">
                                <div class="col-md-12">
                                   {!! with(new \App\Customer\Paginator\SimplePaginator($article))->render() !!}
                               </div>
                           </div>
                        </div>
                        <!-- 分页 结束 -->
                    </div>
                </div>
            </div>
        </div><!--section-inner -->
    </section><!--section -->
</div><!--//primary-->
<!-- 主内容 结束 -->
@endsection
