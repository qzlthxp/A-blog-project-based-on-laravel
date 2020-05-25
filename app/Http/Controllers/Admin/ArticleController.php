<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Cate;
use Illuminate\Support\Facades\Storage;
use App\Model\Article;
use Illuminate\Support\Facades\Redis;
use Intervention\Image\ImageManagerStatic as Image;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $arts = Article::get();
        // $arts = [];
        
        // $listkey = 'LIST:ARTICLE';
        // $hashkey = 'HASH:ARTICLE:';
        // // redis中存在要取的文章
        // if(Redis::exists($listkey)){
        //     // 存放所有要获取的文章的id
        //     $list = Redis::lrange($listkey,0,-1);
        //     foreach($list as $k=>$v){
        //         $arts[] = Redis::hgetall($hashkey.$v);
        //     }

        // }else{
        //    $arts = Article::get()->toArray();
        //    foreach($arts as $k=>$v){
        //         // 将文章的id添加到listkey
        //         Redis::rpush($listkey,$v['art_id']);
        //         // 文章添加hashkey
        //         Redis::hmset($hashkey.$v['art_id'],$v);
        //    }
            
        // }

        return view('admin.article.list',compact('arts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $cates = Cate::tree();
        return view('admin.article.add',compact('cates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $input = $request->except('_token');
        $cate_id = $input['cate_id'];
        $art_title = $input['art_title'];
        $art_editor = $input['art_editor'];
        $art_tag = $input['art_tag'];
        $art_description = $input['art_description'];
        $res = Article::create(['art_title'=>$art_title,'art_tag'=>$art_tag,'art_description'=>$art_description,'art_editor'=>$art_editor,'cate_id'=>$cate_id]);
        if($res){
            return redirect('/admin/article');
        }else{
            return back()->with('msg','添加失败');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //view('admin.article.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $article = Article::find($id);
        $article->delete();
        $res = $article->save();
        if($res){
            $data = [
                'status'=>'0',
                'message'=>'删除成功',
            ];
        }else{
            $data = [
                'status'=>'1',
                'message'=>'删除失败',
            ];
        }

        return $data;
    }


    // 文件上传
    public function upload(Request $request)
    { 
        $fileCharater = $request->file('photo');

        if ($fileCharater->isValid()) { 
            $ext = $fileCharater->getClientOriginalExtension();

            
            $path = $fileCharater->getRealPath();

            
            $filename = md5(date('Y-m-d-h-i').rand(100,999)).'.'.$ext;

            
            Storage::disk('local')->put($filename, file_get_contents($path));
   
            return response()->json(['ServerNo'=>'200','ResultData'=>$filename]); 
        
        }else{
            return response()->json(['ServerNo'=>'404','ResultData'=>'无效的上传文件']);
        }
    
        
    }

    // 批量删除
    public function delAll(Request $request)
    {
        $input = $request->input('ids');
        $res = Article::destroy($input);
        if($res){
            $data = [
                'status'=>'0',
                'message'=>'删除成功',
            ];
        }else{
            $data = [
                'status'=>'1',
                'message'=>'删除失败',
            ];
        }

        return $data;
    }
}
