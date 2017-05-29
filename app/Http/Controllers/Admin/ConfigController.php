<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Model\Config;

use Illuminate\Support\Facades\Input;

use  Illuminate\Support\Facades\Validator;

// +--------------------------------+--------------------------------+------------------------+
// | Method                         | URI                            | Name                   |
// +--------------------------------+--------------------------------+------------------------+
// | GET|HEAD                       | admin/config                    | admin.config.index      |
// | POST                           | admin/config                    | admin.config.store      |
// | GET|HEAD                       | admin/config/create             | admin.config.create     |
// | GET|HEAD                       | admin/config/{config}            | admin.config.show       |
// | PUT|PATCH                      | admin/config/{config}            | admin.config.update     |
// | DELETE                         | admin/config/{config}            | admin.config.destroy    |
// | GET|HEAD                       | admin/config/{config}/edit       | admin.config.edit       |
// +--------------------------------+--------------------------------+------------------------+

/**
 * 后台网站配置控制器
 * @return [type] [description]
 */
class ConfigController extends CommonController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Config::orderBy('sort', 'ASC')->get();
        foreach ($data as $k => $v) {
            switch ($v->fieldtype) {
                case 'input':
                    $data[$k]->html = '<input type="text" class="lg" name="content[]" value="' . $v->content . '">';
                    break;
                case 'textarea':
                    $data[$k]->html = '<textarea name="content[]">' . $v->content . '</textarea>';
                    break;
                case 'radio':
                    //分割：1|开启,0|关闭
                    $arr = explode(',', $v->fieldvalue);
                    $str = '';
                    foreach ($arr as $m => $n) {
                        //1,开启
                        $r = explode('|', $n);
                        $c = $v->content == $r[0] ? ' checked ' : '';
                        $str .= '<input type="radio" name="content[]" value="' . $r[0] . '"' . $c .'>' . $r[1] . '&nbsp;&nbsp;&nbsp;';
                    }
                    $data[$k]->html = $str;
                    break;
            }
        }
        return view('admin.config.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.config.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = Input::except('_token');

        $rules = [
            'name' => 'required',
            'title' => 'required',
        ];

        $message = [
            'name.required' => '请输入配置项名称！',
            'title.required' => '请输入配置项标题！',
        ];

        $validator = Validator::make($input, $rules, $message);
        if($validator->passes())
        {
            if(Config::create($input))
            {
                return redirect('admin/config');
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
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $config = Config::find($id);

        return view('admin/config/edit', compact('config'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = Input::except(['_token', '_method']);

        $rules = [
            'name' => 'required',
            'title' => 'required',
        ];

        $message = [
            'name.required' => '请输入配置项名称！',
            'title.required' => '请输入配置项标题！',
        ];

        $validator = Validator::make($input, $rules, $message);
        if($validator->passes())
        {
            if(Config::where('id', $id)->update($input))
            {
                $this->writeConfig();
                return redirect('admin/config');
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
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Config::where('id', $id)->delete())
        {
            $this->writeConfig();
            return 0; // 删除成功，返回错误码0
        }
        else
        {
            return 1; // 删除失败，返回错误码1
        }
    }

    /**
     * 从数据库写配置项到文件 config/web.php
     * @return [type] [description]
     */
    public function writeConfig()
    {
        $config = Config::pluck('content', 'name')->all();

        $filename = config_path() . '/web.php';
        file_put_contents($filename, "<?php\r\nreturn " . var_export($config , true) . ";\r\n?>");
    }

    /**
     * 更新配置项内容表单处理
     * @return [type] [description]
     */
    public function changeContent()
    {
        $input = Input::all();
        foreach ($input['id'] as $k => $v) {
            Config::where('id', $v)->update(['content' => $input['content'][$k]]);
        }

        $this->writeConfig();
        return redirect('admin/config')->with('errors', '修改成功！');
    }

    /**
     * 异步更新导航的排序字段`sort`
     * @return [type] [description]
     */
    public function changeSort()
    {
        $input = Input::all();

        if(Config::where('id', $input['id'])->update(['sort' => $input['sort']]))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
}
