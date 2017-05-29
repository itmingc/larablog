<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Model\Links;

use Illuminate\Support\Facades\Input;

use  Illuminate\Support\Facades\Validator;

// +--------------------------------+--------------------------------+------------------------+
// | Method                         | URI                            | Name                   |
// +--------------------------------+--------------------------------+------------------------+
// | GET|HEAD                       | admin/links                    | admin.links.index      |
// | POST                           | admin/links                    | admin.links.store      |
// | GET|HEAD                       | admin/links/create             | admin.links.create     |
// | GET|HEAD                       | admin/links/{links}            | admin.links.show       |
// | PUT|PATCH                      | admin/links/{links}            | admin.links.update     |
// | DELETE                         | admin/links/{links}            | admin.links.destroy    |
// | GET|HEAD                       | admin/links/{links}/edit       | admin.links.edit       |
// +--------------------------------+--------------------------------+------------------------+

/**
 * 后台友情链接控制器
 * @return [type] [description]
 */
class LinksController extends CommonController
{
    /**
     * 友情链接列表视图
     * GET|HEAD                       | admin/links                 | admin.links.index
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Links::orderBy('sort', 'ASC')->get();

        return view('admin.links.index', compact('data'));
    }

    /**
     * 添加友情链接视图
     * GET|HEAD                       | admin/links/create          | admin.links.create
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.links.add', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     * POST                           | admin/links                 | admin.links.store
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = Input::except('_token');

        $rules = [
            'name' => 'required',
            'url' => 'required'
        ];

        $message = [
            'name.required' => '请输入链接名称！',
            'url.required' => '请输入URL！'
        ];

        $validator = Validator::make($input, $rules, $message);
        if($validator->passes())
        {
            if(Links::create($input))
            {
                return redirect('admin/links');
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
     * GET|HEAD                       | admin/links/{links}      | admin.links.show
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * GET|HEAD                       | admin/links/{links}/edit | admin.links.edit
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $links = Links::find($id);

        return view('admin/links/edit', compact('links'));
    }

    /**
     * Update the specified resource in storage.
     * PUT|PATCH                      | admin/links/{links}      | admin.links.update
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = Input::except(['_token', '_method']);

        $rules = [
            'name' => 'required',
            'url' => 'required'
        ];

        $message = [
            'name.required' => '请输入链接名称！',
            'url.required' => '请输入URL！'
        ];

        $validator = Validator::make($input, $rules, $message);
        if($validator->passes())
        {
            if(Links::where('id', $id)->update($input))
            {
                return redirect('admin/links');
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
     * Remove the specified resource from storage.
     * DELETE                         | admin/links/{links}      | admin.links.destroy
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Links::where('id', $id)->delete())
        {
            return 0; // 删除成功，返回错误码0
        }
        else
        {
            return 1; // 删除失败，返回错误码1
        }
    }

    /**
     * 异步更新友情链接的排序字段`sort`
     * @return [type] [description]
     */
    public function changeSort()
    {
        $input = Input::all();

        if(Links::where('id', $input['id'])->update(['sort' => $input['sort']]))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
}
