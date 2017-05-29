<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * 分类表模型
 * @return [type] [description]
 */
class Category extends Model
{
	// 表名
    protected $table = 'category';
    // 主键
    protected $primaryKey = 'id';
    // 取消时间戳
    public $timestamps = false;
    // 字段拍除：空。填充（MassAssignment）所有字段
    protected $guarded = [];


    /**
	 * 传递父级分类ID返回所有子分类ID
	 * @param  [type] $cate 要递归的数组
	 * @param  [type] $pid  父级分类ID
	 * @return [type]       [description]
	 */
	static public function getChildrenId($cate, $pid){
		$arr = array();
		foreach($cate as $v){
			if($v->pid == $pid){

				$arr[] = $v['id'];
				$arr = array_merge($arr, self::getChildrenId($cate, $v['id']));
			}
		}
		return $arr;
	}

    /**
     * 获取视图型的分类列表，返回一维数组
     * @return [type] [description]
     */
    static public function getViewCateList(){
        $category = self::orderBy('sort', 'ASC')->get();
        $category = self::unlimitedForLevel($category);

        return $category;
    }

    /**
     * 无限极分类，返回一维数组
     *
     * @param  [type]  $cate        [description]
     * @param  integer $target_levl 传递2表示获取到第2级分类为止，默认为2
     * @param  [type]  $now_level   [description]
     * @return [type]               [description]
     */
    static public function unlimitedForLevel($cate, $html = '─', $pid = 0, $level = 1){
        $arr = array();
        foreach($cate as $v){
            if($v['pid'] == $pid){
                $v['level'] = $level;
                $v['html'] = str_repeat($html, $level - 1);
                $arr[] = $v;
                $arr = array_merge($arr, self::unlimitedForLevel($cate, $html, $v['id'], $level + 1));
            }
        }
        return $arr;
    }

    /**
     * 获取父级分类
     * @return [type] [description]
     */
    static public function getCateTree($id){
        $allCate = self::select('id', 'name', 'pid')->get();
        $cateTree = self::getParents($allCate, $id);

        return $cateTree;
    }

    /**
     * 传递子分类ID返回所有父级分类
     * @param  [type] $cate 要递归的数组
     * @param  [type] $id   子分类ID
     * @return [type]       [description]
     */
    static public function getParents($cate, $id){
        $arr = array();
        foreach($cate as $v){
            if($v->id == $id){
                $arr[] = $v;
                $arr = array_merge(self::getParents($cate, $v['pid']), $arr);
            }
        }
        return $arr;
    }
}
