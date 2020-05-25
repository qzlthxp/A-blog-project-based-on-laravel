<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Permission::get();
        return view('admin.permission.list',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.permission.add');
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
        $permission = $request->except('_token');

        $per_name = $permission['per_name'];
        $res = Permission::create(['per_name'=>$per_name]);
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
        $permission = Permission::find($id);
        return view('admin.permission.edit',compact('permission'));
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
        $input = $request->except('_token');
        $permission = Permission::find($id);
        $permission->per_name = $input['per_name'];
        $res = $permission->save();
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $permission = Permission::find($id);
        $res = $permission->delete();
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
        return $data;
    }


    // 批量删除
    public function delAll(Request $request)
    {
        $permission = $request->input('ids');
        $res = Permission::destroy($permission);
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
