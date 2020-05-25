<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Cate;

class CommonController extends Controller
{
    //
    public function __construct()
    {
        $cate = Cate::get();
        $cateone = [];
        $catetwo = [];

        foreach($cate as $k=>$v)
        {   
            if($v->cate_pid == 0){
                $cateone[$k] = $v;
                foreach($cate as $m=>$n){
                    if($v->cate_id == $n->cate_pid){
                        $catetwo[$k][$m] = $n;
                    }
                }
            } 

        }

        view()->share('cateone',$cateone);
        view()->share('catetwo',$catetwo);
    }
}
