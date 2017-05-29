<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Model\Category;

use App\Http\Model\Article;

use Cache;


/**
 * 列表页控制器
 */
class CategoryController extends CommonController
{
    /**
     * 分类视图
     * @return [type] [description]
     */
    public function index($id)
    {
        // 浏览次数+1
        Category::where('id', $id)->increment('click');

        // 该分类
        $cate = Category::select('id', 'name', 'description', 'keywords')->find($id);

        // 所有其他分类：兄弟分类 或 父级分类
        // $pid = Category::where('id', $id)->value('pid');
        // $otherCate = Category::select('id', 'name')->where('pid', $pid)->orderBy('click', 'DESC')->get(); // 兄弟分类
        // if($otherCate->count() == 1){// 没有兄弟分类时取父级分类
        //     $otherCate = Category::select('id', 'name')->where('id', $pid)->orderBy('click', 'DESC')->get();
        // }
        
        // 父级分类树
        $cateTree = Category::getCateTree($id);

        // 当前分类
        $curId = $id;

        // 分类文章 和 子分类文章
        $allCateIds = Category::select('id', 'pid')->get();
        $cateIds = Category::getChildrenId($allCateIds, $id); // 子分类ID
        $cateIds[] = $id;// 压入分类ID
        $data = Article::select('id', 'title', 'time', 'thumb', 'author', 'cid', 'description')->whereIn('cid', $cateIds)->orderBy('time', 'DESC')->paginate(10);

        return view('index.category.index', compact('cate', 'otherCate', 'curId', 'cateTree', 'data'));
    }
}
