<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Home\CommonController;
use App\Model\Cate;
use App\Model\Collect;
use App\Model\Article;

class IndexController extends   CommonController
{
    //前台首页
    public function index()
    {
        $cate_arts = Cate::where('cate_pid','<>',0)->with('article')->get();
        // dd($cate_arts);
        return view('home.index',compact('cate_arts'));
    }

    // 文章收藏
    public function collect(Request $request)
    {
        $uid = $request->input('uid');
        $artid = $request->input('artid');
        $act = $request->input('act');

        // 判断操作是收藏还是取消收藏
        switch($act){
            case 'add':
                $collect = Collect::where([
                    'uid','=',$uid,
                    'art_id','=',$artid,
                ])->get();
                if($collect->isEmpty()){
                    $res = Collect::create(['uid'=>$uid,'art_id'=>$artid]);
                    Article::where('art_id',$artid)->increment(['art_collect']);
                    if($res){
                        return response()->json(['status'=>0,'msg'=>'已收藏']);
                    }else{
                        return response()->json(['status'=>1,'msg'=>'收藏失败']);
                    }
                }else{
                    return response()->json(['status'=>0,'msg'=>'已收藏']);
                }
                
            break;
            
            case 'remove':
                $collect = Collect::where([
                    'uid','=',$uid,
                    'art_id','=',$artid,
                ])->get();
                if(!$collect->isEmpty()){
                    $res = $collect->delete();
                    Article::where('art_id',$artid)->decrement(['art_collect']);
                    if($res){
                        return response()->json(['status'=>0,'msg'=>'请收藏']);
                    }else{
                        return response()->json(['status'=>1,'msg'=>'取消收藏失败']);
                    } 
                }else{
                    return response()->json(['status'=>0,'msg'=>'请收藏']);
                }
                

                
            break;
        }



    }
}
