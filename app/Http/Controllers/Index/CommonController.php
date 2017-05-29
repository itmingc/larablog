<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Input;

use App\Http\Controllers\Controller;

use App\Http\Model\Navs;

use App\Http\Model\Article;

use App\Http\Model\Category;

use App\Http\Model\Tag;

use App\Http\Model\Links;

use Illuminate\Support\Facades\View;

use DB;

use Illuminate\Support\Facades\Cache;


/**
 * 前台公共控制器
 */
class CommonController extends Controller
{
    /**
     * 读取共享变量
     */
    public function __construct() {

        // 导航栏：读取顶级分类前5个
        if(!$topCate = Cache::get('topCate')){
            $topCate = Category::where('pid', 0)->orderBy('sort', 'ASC')->select('id', 'name', 'title')->take(5)->get();
            Cache::put('topCate', $topCate, 60 * 24); // 缓存一天
        }

        // 分类排行（导航右侧隐藏栏）
        if(!$cateRank = Cache::get('cateRank')){
            $cateRank = Category::select('id', 'name', 'click', 'title')->orderBy('click', 'DESC')->take(30)->get();
            Cache::put('topCate', $topCate, 60); // 缓存一小时
        }

        // 最新发布（分页）
        $new = Article::select('id', 'title', 'content', 'time', 'thumb', 'author', 'cid', 'description')->orderBy('time', 'DESC')->simplePaginate(10);

        // 热门标签
        if(!$hotTag = Cache::get('hotTag')){
            $hotTag = Tag::select('id', 'name', 'count')->orderBy('count', 'DESC')->take(40)->get();
            Cache::put('hotTag', $hotTag, 10); // 缓存10分钟
        }

        // 阅读排行榜
        if(!$readRank = Cache::get('readRank')){
            $readRank = Article::select('id', 'title', 'description', 'click')->orderBy('click', 'DESC')->take(10)->get();
            Cache::put('readRank', $readRank, 10); // 缓存10分钟
        }

        // 最新发布
        if(!$newPub = Cache::get('newPub')){
            $newPub = Article::select('id', 'title', 'content', 'time', 'thumb', 'author', 'cid', 'description')->orderBy('time', 'DESC')->get();
            Cache::put('newPub', $newPub, 10); // 缓存10分钟
        }

        // 随机推荐
        if(!$randRecommend = Cache::get('randRecommend')){
            $randRecommend = Article::select('id', 'title')->inRandomOrder()->take(10)->get();
            Cache::put('randRecommend', $randRecommend, 10); // 缓存10分钟
        }

        // 友情链接
        if(!$links = Cache::get('links')){
            $links = Links::select('name', 'title', 'url')->orderBy('sort', 'ASC')->get();
            Cache::put('links', $links, 60 * 24 * 15); // 缓存半个月
        }

        View::share('topCate', $topCate);
        View::share('cateRank', $cateRank);
        View::share('new', $new);
        View::share('hotTag', $hotTag);
        View::share('readRank', $readRank);
        View::share('newPub', $newPub);
        View::share('randRecommend', $randRecommend);
        View::share('links', $links);
    }

    /**
     * 标签文章视图
     * @return [type] [description]
     */
    public function tag($id)
    {
        $tag = Tag::find($id);
        $article = $tag->articles()->simplePaginate(10);

        return view('index.common.tag', compact('tag', 'article'));
    }

    /**
     * 关键字文章视图
     * @return [type] [description]
     */
    public function search()
    {
        $kw = Input::get('kw');

        // 查找含有关键字的标签
        $tag = Tag::where('name', 'like', '%' . $kw . '%')->first();
        if($tag){ // 如果有这个关键字标签
            // 用这个标签查找文章
            $article = $tag->articles()
            ->select('article.id', 'title', 'description', 'thumb', 'time', 'author', 'cid')
            ->simplePaginate(10);
        }
        else if($cid = Category::where('name', 'like', '%' . $kw . '%')->value('id')){ //否则，查找分类名含有关键字的文章
            $article =  Article::where('cid', $cid)
            ->select('id', 'title', 'description', 'thumb', 'time', 'author', 'cid')
            ->simplePaginate(10);
        }
        else{ // 否则，查找文章表中标题或描述或作者名含有关键字的文章
            $article = Article::where('title', 'like', '%' . $kw . '%')
            ->orWhere('description', 'like', '%' . $kw . '%')
            ->orWhere('author', 'like', '%' . $kw . '%')
            ->select('id', 'title', 'description', 'thumb', 'time', 'author', 'cid')
            ->simplePaginate(10);
        }

        return view('index.common.search', compact('kw', 'article'));
    }
}
