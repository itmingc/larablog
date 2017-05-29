<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Input;

use Gregwar\Captcha\CaptchaBuilder;

use DB;

use App\Http\Model\Admin;

/**
 * 后台登录控制器
 */
class LoginController extends CommonController
{

    /**
     * 登录视图 和 表单处理
     * @return [type] [description]
     */
    public function login(){

    	if($input = Input::get())
        {
            // 验证验证码
            if(strtolower($input['code']) != strtolower(session('phrase')))
            {
                return back()->with('msg', '验证码有误！');
            }

            // 验证用户名和密码
            $admin = Admin::where('username', $input['username'])->first();

            if(!$admin ||  md5($input['password']) != $admin->password)
            {
                return back()->with('msg', '用户名或密码有误！');
            }

            // 通过验证
            session(['uname'=> $admin->username]);
            return redirect('admin/index');
        }
        else
        {
            return view('admin.login.index');
        }
    }

    /**
     * 生成验证码
     * @return [type] [description]
     */
    public function captcha(){
        $builder = new CaptchaBuilder;

        //设置图片宽高
        $builder->build($width = 140, $height = 48);

        //获取验证码内容
        $phrase = $builder->getPhrase();

        //写入session
        session(['phrase' => $phrase]);

        //生成图片
        header('Content-Type: image/jpeg');
        ob_clean();
        flush();
        $builder->output();
    }
}
