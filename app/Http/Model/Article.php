<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * 文章表模型
 */
class Article extends Model
{
    // 表名
    protected $table = 'article';
    // 主键
    protected $primaryKey = 'id';
    // 取消时间戳
    public $timestamps = false;
    // 字段排除：空。填充（MassAssignment）所有字段
    protected $guarded = [];


    /**
     * 关联标签表
     * @return [type] [description]
     */
    public function tags(){
        return $this->belongsToMany('App\Http\Model\Tag' , 'article_tag', 'aid', 'tid');
    }

    /**
     * 关联分类表
     * @return [type] [description]
     */
    public function category()
    {
        return $this->belongsTo('App\Http\Model\Category' , 'cid')->select('id', 'name');
    }
}
