<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Links extends Model
{
    // 表名
    protected $table = 'links';
    // 主键
    protected $primaryKey = 'id';
    // 取消时间戳
    public $timestamps = false;
    // 字段拍除：空。填充（MassAssignment）所有字段
    protected $guarded = [];
}
