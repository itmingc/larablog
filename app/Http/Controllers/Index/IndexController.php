<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;

use App\Http\Requests;

/**
 * 前台首页控制器
 */
class IndexController extends CommonController
{
    /**
     * 首页视图
     * @return [type] [description]
     */
    public function index()
    {
        return view('index.index.index');
    }
}
