<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Input;

/**
 * 后台公共控制器
 * @return [type] [description]
 */
class CommonController extends Controller
{
    /**
     * 缩略图上传
     * @return [type] [description]
     */
    public function upload()
    {
        $file = Input::file('Filedata');
        if($file -> isValid())
        {
            // 上传目录。 public目录下 uploads/thumb 文件夹
			$dir = 'uploads/thumb/';
            // 文件名。格式：时间戳 + 6位随机数 + 后缀名
			$filename = time() . mt_rand(100000, 999999) . '.' . $file ->getClientOriginalExtension();

			$file->move($dir, $filename);
            $path = $dir . $filename;

			return url($path);
        }
    }
}
