<?php


namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Model\Article;

use App\Http\Model\Category;

use App\Http\Model\Tag;

use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Validator;

use DB;

// +--------------------------------+--------------------------------+------------------------+
// | Method                         | URI                            | Name                   |
// +--------------------------------+--------------------------------+------------------------+
// | GET|HEAD                       | admin/article                  | admin.article.index    |
// | POST                           | admin/article                  | admin.article.store    |
// | GET|HEAD                       | admin/article/create           | admin.article.create   |
// | PUT|PATCH                      | admin/article/{article}        | admin.article.update   |
// | DELETE                         | admin/article/{article}        | admin.article.destroy  |
// | GET|HEAD                       | admin/article/{article}        | admin.article.show     |
// | GET|HEAD                       | admin/article/{article}/edit   | admin.article.edit     |
// +--------------------------------+--------------------------------+------------------------+

/**
 * 后台文章控制器
 * @return [type] [description]
 */
class ArticleController extends CommonController
{
    /**
     * 文章列表视图
     * GET|HEAD                       | admin/article                  | admin.article.index
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 文章列表 和 分页
        $article = Article::orderBy('time', 'DESC')->paginate(10);

        return view('admin.article.index', compact('article'));
    }

    /**
     * 添加文章视图
     * GET|HEAD                       | admin/article/create           | admin.article.create
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::getViewCateList();

        return view('admin.article.add')->with('category', $category);
    }

    /**
     * 添加文章表单处理
     * POST                           | admin/article                  | admin.article.store
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = Input::except('_token');

        // 数据验证
        $rules = [
            'cid' => 'not_in:0', // 分类ID 不能为0
            'title' => 'required',
            'content' => 'required'
        ];
        $message = [
            'cid.not_in' => '请选择一个分类！',
            'title.required' => '请输入文章标题！',
            'content.required' => '请输入文章内容！'
        ];
        $validator = Validator::make($input, $rules, $message);

        if($validator->passes())
        { // 验证通过，填充数据

            // 处理数据
            $input['time'] = time();
            $input['thumb'] = 'uploads/thumb/' . basename($input['thumb']);

            if(!trim($input['description'])){// 如果没有文章概述，则填充文章内容的前150个文字到概述中
                $input['description'] = substr(strip_tags($input['content']), 0, 150);
            }

            // 处理标签
            $tags = $input['tag']; // 得到tag 标签数据，准备更新tag表和中间表article_tag
            unset($input['tag']); //清掉tag 字段，文章表不用它

            if(!$id = DB::table('article')->insertGetId($input))
            { // 失败
                return back()->with('error', '添加文章失败，请重试');
            }
            else
            { //成功

                // 处理 tag 字段，更新 tag 表和中间表 article_tag
                if($tags) Tag::updateTag(0, $tags, $id);

                return redirect('admin/article');
            }
        }
        else
        {
            return back()->withErrors($validator->errors($validator));
        }
    }

    /**
     * Display the specified resource.
     * GET|HEAD                       | admin/article/{article}        | admin.article.show
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * 修改文章视图.
     * GET|HEAD                       | admin/article/{article}/edit   | admin.article.edit
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!preg_match('/^\d+$/', $id))
        {
            return (new Exception("非法操作", 1));
        }

        // 取分类
        $category = Category::getViewCateList();
        // 取该ID记录
        $article = Article::find($id);

        return view('admin/article/edit')->with('article', $article)->with('category', $category);
    }

    /**
     * Update the specified resource in storage.
     * PUT|PATCH                      | admin/article/{article}        | admin.article.update
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = Input::except(['_token', '_method']);
        $input['thumb'] = 'uploads/thumb/' . basename($input['thumb']);
        
        $tags = $input['tag']; // 得到tag 标签数据，准备更新tag表和中间表article_tag
        unset($input['tag']); //清掉tag 字段，文章表不用它

        // 数据验证
        $rules = [
            'cid' => 'not_in:0', // 分类ID 不能为0
            'title' => 'required',
            'content' => 'required'
        ];
        $message = [
            'cid.not_in' => '请选择一个分类！',
            'title.required' => '请输入文章标题！',
            'content.required' => '请输入文章内容！'
        ];
        $validator = Validator::make($input, $rules, $message);

        if($validator->passes())
        {
            if(!trim($input['description'])){// 如果没有文章概述，则填充文章内容的前150个文字到概述中
                $input['description'] = substr(strip_tags($input['content']), 0, 150);
            }

            Article::where('id', $id)->update($input);
            Tag::updateTag(1, $tags, $id);

            return redirect('admin/article');
        }
        else
        {
            return back()->withErrors($validator->errors($validator));
        }
    }

    /**
     * 异步删除文章
     * DELETE                         | admin/article/{article}        | admin.article.destroy
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Article::where('id', $id)->delete())
        {
            // 处理文章标签
            Tag::updateTag(2, null, $id);
            return 0; // 删除成功，返回错误码0
        }
        else
        {
            return 1; // 删除失败，返回错误码1
        }
    }
}
