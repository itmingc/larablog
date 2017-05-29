<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * 后台用户表模型
 * @var string
 */
class Admin extends Model
{
	// 表名
    protected $table = 'admin';
    // 主键
    protected $primaryKey = 'id';
    // 取消时间戳
    public $timestamps = false;
}
