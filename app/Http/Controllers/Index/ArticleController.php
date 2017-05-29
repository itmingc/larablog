<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Model\Article;

use App\Http\Model\Category;

use Cache;

/**
 * 展示页控制器
 */
class ArticleController extends CommonController
{
    /**
     * 文章正文视图
     * @return [type] [description]
     */
    public function index($id)
    {
        // 浏览次数+1
        Article::where('id', $id)->increment('click');

        // 该文章
        $article = Article::select('id', 'title', 'content', 'time', 'author', 'click', 'cid')->find($id);
        Cache::put('article', $article, 60);


        // 所属分类
        $belongsCate = $article->category()->select('name')->first();
        Cache::put('belongsCate', $belongsCate, 60); // 缓存一小时


        // 所属标签
        $belongsTag = $article->tags()->get();
        Cache::put('belongsTag', $belongsTag, 60); // 缓存一小时


        // 父级分类树 例如： 首页 / 新闻 / 娱乐新闻
        $cateTree = Category::getCateTree($article->cid);
        Cache::put('cateTree', $cateTree, 60); // 缓存一小时


        // 上一篇、下一篇
        $article['pre'] = Article::select('id', 'title')->where('id', '<', $id)->first();
        $article['next'] = Article::select('id', 'title')->where('id', '>', $id)->first();

        // 相关推荐
        $relation = Article::select('id', 'title')->where('cid', $article->cid)->orderBy('id', 'DESC')->take(5)->get();
        Cache::put('relation', $relation, 60); // 缓存一小时


        return view('index.article.index', compact('belongsCate', 'belongsTag', 'cateTree', 'article', 'relation'));
    }
}
