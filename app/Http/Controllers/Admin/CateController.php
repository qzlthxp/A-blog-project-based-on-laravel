<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Cate;

class CateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $cate = Cate::tree();
        return view('admin.cate.list',compact('cate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //获取一级类
        $cate = Cate::where('cate_pid',0)->get();


        return view('admin.cate.add',compact('cate'));
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
        $res = Cate::create($input);
        if($res){
            $data = [
                'status'=>0,
                'message'=>'添加成功',
            ];
            
        }else{
            $data = [
                'status'=>1,
                'message'=>'添加失败',
            ];
        }
        return $data;
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
        //
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
        $cate = Cate::find($id);
        $cate->delete();
        $res = $cate->save();
        if($res){
            $data = [
                'status'=>0,
                'message'=>'删除成功',
            ];
        }else{
            $data = [
                'status'=>1,
                'message'=>'删除失败',
            ];
        }
    }

    // 批量删除
    public function delAll(Request $request)
    {
        $input = $request->input(['ids']);
        $res = Cate::destroy($input);
        if($res){
            $data = [
                'status'=>0,
                'message'=>'删除成功',
            ];
        }else{
            $data = [
                'status'=>1,
                'message'=>'删除失败',
            ];
        }
    }
}
