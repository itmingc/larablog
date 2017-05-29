@extends('layouts.index')

@section('webconfig')
<meta name="keywords" content="{{$article->tag}}" />
<meta name="description" content="{{$article->description}}" />
<title>{{$article->title}} - {{config('web.web_title')}}</title>
@endsection

@section('css')
<style media="screen">
    .location{
        font-size: 14px;
    }

    [class^='post-']{
        padding-top: 10px;
        font-size: 13px;
        color: #777;
    }
    [class^='post-'] i{
        color: #f4645f;
    }
    li{
        line-height: 2;
    }
    .content{
        padding-bottom: 0;
    }

    /* 相关推荐 */
    /*.post-other ul li{
        list-style: disc;
    }*/

    /* 发表评论 */
    /*input, textarea{
        padding: 3px 5px;
        width: 170px;
        border: 1px solid #ccc;
        outline: 0 none;
        border-radius: 3px;
    }
    textarea{
        width: 100%;
        min-height: 70px;
    }
    input:focus, textarea:focus{
        border-color: #3793ff;
    }
    .post-one .per-row{
        padding-left: 20px;
        padding-top: 10px;
    }
    .post-one .per-row label{
        font-weight: 400;
    }*/

    /* 相关评论 */
    /*.post-comment li{
        padding-top: 10px;
    }
    .post-comment a{
        color: #777;
    }
    .post-comment .well{
        position: relative;
        color: #999;
    }
    .post-comment .well::before{
        content: '';
        position: absolute;
        left: 6px;
        top: -16px;
        display: block;
        width: 0;
        height: 0;
        border: 8px solid #e3e3e3;
        border-top-color: transparent;
        border-right-color: transparent;
        border-left-color: transparent;
        background: transparent;
    }*/
</style>
@endsection

@section('primary')
<!-- 主内容 开始 -->
<div class="primary col-md-9 col-sm-12 col-xs-12">
    <section class="section">
    <div class="section-inner">
        <h2 class="heading page-header text-center">{{$article->title}}<br><br>
        <small class="post-category">
            <i class="fa fa-folder-open"></i>&nbsp;<strong>分类：</strong><a href="{{url('cate/' . $article->cid)}}">{{$belongsCate->name}}</a>
        </small>&nbsp;&nbsp;
        <small class="post-tag">
            <i class="fa fa-tags"></i><strong>标签：</strong>
            <?php $class = ['label-default', 'label-primary', 'label-success', 'label-info', 'label-warning', 'label-danger'] ?>
            @foreach($belongsTag as $v)
                <a href="{{url('tag/' . $v->id)}}"><span class="label {{$class[mt_rand(0, 5)]}}">{{$v->name}}</span></a>
            @endforeach
        </small>

        </h2>

        <div class="content">
            <div class="row">
                <div class="col-md-12">{!!$article->content!!}</div>
            </div>
        </div>
        <div class="post-desc">
            <div class="row">
                <div class="col-md-12">
                    <p class="pull-right">posted on {{date('Y-m-d H:i', $article->time)}} &nbsp;编辑：<span>{{$article->author}}</span>&nbsp;浏览：<span>{{$article->click}}</span></p>
                </div>
            </div>
        </div>
        <!-- <div class="post-category">
            <p><i class="fa fa-folder-open"></i>&nbsp;<strong>分类：</strong><a href="{{url('cate/' . $article->cid)}}">{{$belongsCate->name}}</a></p>
        </div> -->
        <div class="post-pre-next">
            <ul class="list-unstyled">
                @if($article['pre'])
                    <li class=""><strong> <i class="fa fa-arrow-left"></i> 上一篇：</strong><a href="{{url('a/' . $article['pre']->id)}}">{{$article['pre']->title}}</a></li>
                @endif
                @if($article['next'])
                    <li class=""><strong><i class="fa fa-arrow-right"></i> 下一篇： </strong><a href="{{url('a/' . $article['next']->id)}}">{{$article['next']->title}}</a></li>
                @endif
            </ul>
            <br>
        </div>
        <div class="post-other">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="heading page-header"><i class="fa fa-glass"></i>&nbsp;相关推荐</h3>
                    <!-- <p><strong><i class="fa fa-glass"></i>&nbsp;相关推荐</strong></p> -->
                    <ul class=" ">
                        @foreach($relation as $v)
                            <li><a href="" title="{{url('a/' . $v->id)}}">{{$v->title}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <!-- <div class="post-one">
            <div class="row">
                <div class="col-md-12">
                    <p><strong><i class="fa fa-user-circle"></i>&nbsp;&nbsp;发表评论</strong></p>
                    <form action="" type="post" id="send-form">
                        <input type="hidden" name="reid" value="0">
                        <div class="per-row">
                            <label for="uname" class="">昵称：</label>
                            <input type="text" id="uname" placeholder=""><span> 必填</span>
                        </div>
                        <div class="per-row">
                            <label for="url" class="">网址：</label>
                            <input type="text" id="url" placeholder="" value="http://">
                        </div>
                        <div class="per-row">
                            <label for="email" class="">邮箱：</label>
                            <input type="text"id="email" placeholder="">
                        </div>
                        <div class="per-row">
                            <label for="comment-content" class="">内容（您还可以输入<span id="num" style="color: #111"></span>个字）：</label><br>
                            <textarea type="text" id="comment-content" placeholder=""></textarea>
                        </div>
                        <div class="per-row clearfix">
                            <button id="send-comment" class="btn btn-sm pull-right" type="submit">确认提交</button>
                            <span id="msg" class="pull-right" style="padding: 0 10px; color: #f00;"></span>
                        </div>
                    </form>
                </div>
            </div>
        </div> -->
        <!-- <div class="post-comment">
            <p><strong><i class="fa fa-comments"></i>&nbsp;&nbsp;相关评论(2)</strong></p>
            <ul class="list-unstyled">
                <li>
                    <div class="row">
                        <div class="col-md-1 col-sm-1">
                            <a href="#" target="_blank">
                                <img class="media-object img-responsive" src="./assets/images/avatar.png" alt="...">
                            </a>
                        </div>
                        <div class="col-md-11 col-sm-11">
                            <div class="media-heading">
                                <span><a href="http://" target="_blank">老牛</a> | 2017-05-14 21:17</span>
                                <input type="hidden" name='uid' value="2">&nbsp;&nbsp;
                                <a href="" class="zan"><i class="fa fa-thumbs-up"></i>&nbsp;赞(100)</a>&nbsp;&nbsp;
                                <a href="" class='reply'><i class="fa fa-reply"></i>&nbsp;回复</a>
                            </div>
                            <p>回复：那我也得来一个了，哈哈。</p>
                            <p class="well well-sm">艾德敏 | 2017-05-14 21:17：我来发表一个评论。。。</p>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="row">
                        <div class="col-md-1 col-sm-1">
                            <a href="#" target="_blank">
                                <img class="media-object img-responsive" src="./assets/images/avatar.png" alt="...">
                            </a>
                        </div>
                        <div class="col-md-11 col-sm-11">
                            <div class="media-heading">
                                <span><a href="http://" target="_blank">艾德敏</a> | 2017-05-14 21:17</span>
                                <input type="hidden" name='uid' value="1">&nbsp;&nbsp;
                                <a href="" class="zan"><i class="fa fa-thumbs-up"></i>&nbsp;赞(100)</a>&nbsp;&nbsp;
                                <a href="" class='reply'><i class="fa fa-reply"></i>&nbsp;回复</a>
                            </div>
                            <p>我来发表一个评论。。。</p>
                        </div>
                    </div>
                </li>
            </ul>
        </div> -->
    </div><!-- section-inner -->
</section><!-- section -->
</div><!--//primary-->
<!-- 主内容 结束 -->
@endsection

@section('secondary')
<!-- 位置 开始 -->
 <aside class="aside section">
    <div class="section-inner">
        <small class="location"><i class="fa fa-location-arrow"></i> 位置：<a href="{{url('/')}}">首页</a>
            @foreach($cateTree as $v)
                / <a href="{{url('cate/' . $v->id)}}">{{$v->name}}</a>
            @endforeach
        </small>
    </div><!--//section-inner-->
</aside><!--//aside-->
<!-- 位置 结束 -->
@parent
@endsection
