<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

use DB;

class Article_Tag extends Model
{
    // 表名
    protected $table = 'article_tag';
    // 主键
    protected $primaryKey = 'id';
    // 取消时间戳
    public $timestamps = false;
    // 字段拍除：空。填充（MassAssignment）所有字段
    protected $guarded = [];

}
