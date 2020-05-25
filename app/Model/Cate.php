<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cate extends Model
{
    //
    //
    //    1. 关联的数据表
    public $table = 'category';

    //    2. 主键
    public $primaryKey = 'cate_id';

    //    3. 允许批量操作的字段

    //   public $fillable = ['user_name','user_pass','email','phone'];
    public $guarded = [];

    //    4. 是否维护crated_at 和 updated_at字段

    public $timestamps = false;


    // 格式化分类数据
    public static  function tree()
    {
        // 获取所有的分类数据
        $cates = self::orderBy('cate_order','asc')->get();

        // 格式化 （排序，二级类缩进）
        return self::getTree($cates);

    }

    public static function getTree($category)
    {
        // 排序
        $arr = [];
        // 先获取一级类
        foreach($category as $k=>$v){
            // 一级类
            if($v->cate_pid == 0){
                $arr[] = $v;
                // 获取一级类下的二级类
                foreach($category as $m=>$n){
                    if($v->cate_id == $n->cate_pid){
                        $n->cate_name = '　　　'.$n->cate_name; 
                        $arr[] = $n;
                    }
                }
            }
        }

        return $arr;
    }

    public function article()
    {
        return $this->hasMany('App\Model\Article','cate_id','cate_id');
    }


}
