<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Illuminate\Support\Facades\Input;

use App\Http\Model\Admin;

use Illuminate\Support\Facades\Validator;

/**
 * 后台首页控制器
 */
class IndexController extends CommonController{

	/**
	 * 首页视图
	 * @return [type] [description]
	 */
    public function index(){
    	return view('admin.index.index');
    }

    /**
     * 网站信息视图
     * @return [type] [description]
     */
    public function info(){
    	return view('admin.index.info');
    }

    /**
     * 退出登录
     * @return [type] [description]
     */
    public function logout(){
        session(['uname' => null]);

        return redirect('admin/login');
    }

    /**
     * 修改密码视图 和 表单处理
     * @return [type] [description]
     */
    public function password(){

        if($input = Input::get()){

            $rules = [
                'password_o' => 'required',
                'password' => 'required|between:5,60|confirmed',
            ];

            $message = [
                'password_o.required' => '请输入原密码！',
                'password.required' => '请输入新密码！',
                'password.between' => '新密码必须在 5 - 60 位数字、字母、或下划线之间！',
                'password.confirmed' => '两次密码不一致！'
            ];

            $validator = Validator::make($input, $rules, $message);
            if($validator->passes()){

                $admin = Admin::where('username', session('uname'))->first();
                if($admin && $admin->password == md5($input['password_o'])){

                    $admin->password = md5($input['password']);
                    $admin->update();

                    return back()->with('errors', '密码修改成功！');
                }
                else{
                    return back()->with('errors', '原密码有误！');
                }
            }
            else{
                return back()->withErrors($validator->errors($validator));
            }
        }
        return view('admin.index.password');
    }
}
