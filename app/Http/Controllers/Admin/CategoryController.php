<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Model\Category;

use Illuminate\Support\Facades\Input;

use  Illuminate\Support\Facades\Validator;

// +--------------------------------+--------------------------------+------------------------+
// | Method                         | URI                            | Name                   |
// +--------------------------------+--------------------------------+------------------------+
// | GET|HEAD                       | admin/category                 | admin.category.index   |
// | POST                           | admin/category                 | admin.category.store   |
// | GET|HEAD                       | admin/category/create          | admin.category.create  |
// | GET|HEAD                       | admin/category/{category}      | admin.category.show    |
// | PUT|PATCH                      | admin/category/{category}      | admin.category.update  |
// | DELETE                         | admin/category/{category}      | admin.category.destroy |
// | GET|HEAD                       | admin/category/{category}/edit | admin.category.edit    |
// +--------------------------------+--------------------------------+------------------------+

/**
 * 后台分类控制器
 */
class CategoryController extends CommonController
{
    /**
     * 所有分类列表
     * GET|HEAD                       | admin/category                 | admin.category.index
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data =  Category::getViewCateList();
                
        return view('admin.category.index')->with('data', $data);
    }

    /**
     * 异步更新分类的排序字段`sort`
     * @return [type] [description]
     */
    public function changeSort()
    {
        $input = Input::get();

        if(Category::where('id', $input['id'])->update(['sort' => $input['order']]))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    /**
     * 添加分类视图
     * GET|HEAD                       | admin/category/create          | admin.category.create
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Category::getViewCateList();

        return view('admin.category.add')->with('data', $data);
    }

    /**
     * 添加分类表单处理
     * POST                           | admin/category                 | admin.category.store
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = Input::except('_token');

        $rules = [
            'name' => 'required',
        ];

        $message = [
            'name.required' => '请输入分类名称！'
        ];

        $validator = Validator::make($input, $rules, $message);
        if($validator->passes())
        {
            if(Category::create($input))
            {
                return redirect('admin/category');
            }
            else
            {
                return back()->with('errors', '添加失败，请重试');
            }
        }
        else
        {
            return back()->withErrors($validator->errors($validator));
        }
    }

    /**
     * Display the specified resource.
     * GET|HEAD                       | admin/category/{category}      | admin.category.show
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * 修改分类视图
     * GET|HEAD                       | admin/category/{category}/edit | admin.category.edit
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // 取分类树
        $cateTree = Category::getViewCateList();
        // 取该ID记录
        $category = Category::find($id);

        return view('admin/category/edit')->with('category', $category)->with('cateTree', $cateTree);
    }

    /**
     * 修改分类表单处理
     * PUT|PATCH                      | admin/category/{category}      | admin.category.update
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = Input::except(['_token', '_method']);

        $rules = [
            'name' => 'required',
        ];

        $message = [
            'name.required' => '请输入分类名称！'
        ];

        $validator = Validator::make($input, $rules, $message);
        if($validator->passes())
        {
            if(Category::where('id', $id)->update($input))
            {
                return redirect('admin/category');
            }
            else
            {
                return back()->with('errors', '您没有修改 或 修改失败，请重试');
            }
        }
        else
        {
            return back()->withErrors($validator->errors($validator));
        }

    }

    /**
     * 异步删除分类
     * DELETE                         | admin/category/{category}      | admin.category.destroy
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // 删除分类的逻辑：
        // 第一种：
        //     如果该分类没有子级分类，则直接删除
        //     如果该分类含有子级分类，则禁止删除

        // 第二种：
        // 如果该分类没有子级分类，直接删除
        // 如果该分类含有子级分类，则删除该分类，并将子级分类 pid 改为 该分类的父级的 id
        // 当然，如果最多只有两级分类，那么仅仅需要将子级分类 pid 改为 0，作为顶级分类即可

        // 本博客系统分类层次仅2级，为了稳定和减少误操作的风险，选择第1中思路

        // 有子级分类，禁止删除
        if(Category::where('pid', $id)->first())
        {
            return 1; // 返回错误码1
        }
        else
        {
            if(Category::where('id', $id)->delete())
            {
                return 0; // 删除成功，返回错误码0
            }
            else
            {
                return 2; // 删除失败，返回错误码2
            }
        }
    }

}
