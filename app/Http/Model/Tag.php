<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

use DB;

class Tag extends Model
{
    // 表名
    protected $table = 'tag';
    // 主键
    protected $primaryKey = 'id';
    // 取消时间戳
    public $timestamps = false;
    // 字段拍除：空。填充（MassAssignment）所有字段
    protected $guarded = [];




    /**
     * 关联文章表，获取一个标签对应的多个文章
     * @return [type] [description]
     */
    public function articles(){
        return $this->belongsToMany('\App\Http\Model\Article' , 'article_tag', 'tid', 'aid');
    }



    /**
     * 更新标签表和文章_标签中间表
     * @param  integer $type 对文章的操作类型。0：添加文章，1：修改文章；2：删除文章
     * @param  [type]  $tag  ","号连接的tag标签名。如："标签1,标签2,标签3"
     * @param  [type] $articleId 正在操作的文章ID
     * @return [type]            [description]
     */
    static public function updateTag($type, $tags, $articleId){
        switch ($type) {
            case 0: // 添加文章
                $tags = str_replace('，', ',', $tags); //中文逗号替换为英文逗号
                $tagArr = explode(',', $tags);         // 标签数组

                foreach ($tagArr as $v) {
                    $v = trim($v);

                    // 添加新标签，或 已有标签引用计数 + 1
                    if(!$id = DB::table('tag')->where('name', $v)->value('id')){
                        $id = DB::table('tag')->insertGetId(
                            ['name' => $v, 'count' => 1]
                        );
                    }
                    else{
                        DB::table('tag')->where('id', $id)->increment('count');
                    }

                    // 中间表添加新文章标签
                    DB::table('article_tag')->insert(
                        ['aid' => $articleId, 'tid' => $id]
                    );
                }

                break;


            case 1: // 修改文章
                $tags = str_replace('，', ',', $tags); //中文逗号替换为英文逗号
                $tagArr = explode(',', $tags);         // 标签数组

                // 旧标签id数组
                $pre = DB::table('article_tag')->where('aid', $articleId)->pluck('tid');

                $cur = [];
                foreach ($tagArr as $v) {
                    $v = trim($v);

                    if(!$id = DB::table('tag')->where('name', $v)->value('id')){// 新标签
                        // 添加新标签
                        if($v){
                            $id = DB::table('tag')->insertGetId(
                                ['name' => $v]
                            );
                        }
                    }
                    $cur[] = $id; // 保存本次提交的标签ID

                    if(!in_array($id, $pre)){// 如果本次修改添加了新的标签
                        // 已有标签引用计数 + 1
                        DB::table('tag')->where('id', $id)->increment('count');

                        // 中间表添加新文章标签
                        DB::table('article_tag')->insert(
                            ['aid' => $articleId, 'tid' => $id]
                        );
                    }
                }

                // 旧标签引用计数 - 1 或直接删除，并删除中间表旧的本文章标签记录
                foreach ($pre as $v) {
                    if(!in_array($v, $cur)){ // 如果是本次修改之前旧的标签

                        if(DB::table('tag')->where('id', $v)->value('count') > 1){
                            DB::table('tag')->where('id', $v)->decrement('count');
                        }
                        else{
                            DB::table('tag')->where('id', $v)->delete();
                        }

                        DB::table('article_tag')->where(['tid' => $v, 'aid' => $articleId])->delete();
                    }
                }
                break;

            case 2: // 删除文章
                // 该文章的所有标签ID
                $pre = DB::table('article_tag')->where('aid', $articleId)->pluck('tid');

                // 删除中间表的本文章标签记录
                DB::table('article_tag')->where('aid', $articleId)->delete();

                // 旧标签引用计数 - 1 或直接删除
                foreach ($pre as $v) {
                    if(DB::table('tag')->where('id', $v)->value('count') > 1){

                        DB::table('tag')->where('id', $v)->decrement('count');
                    }
                    else{
                        DB::table('tag')->where('id', $v)->delete();
                    }
                }
                break;
        }
    }
}
