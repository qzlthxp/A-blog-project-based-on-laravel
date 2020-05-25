<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Role;
use App\Model\Permission;
use Illuminate\Support\Facades\DB;


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $role = Role::get();
        return view('admin.role.list',compact('role'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.role.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //获取表单提交数据
        $input = $request->except('_token');
        $role_name = $input['role_name'];
        // dd($input);

        // 表单验证

        // 数据添加到数据库role表
        $res = Role::create(['role_name'=>$role_name]);

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
        $role = Role::find($id);
        return view('admin.role.edit',compact('role'));
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
        $role = Permission::find($id);
        $role->role_name = $input['role_name'];
        $res = $role->save();
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
        $role = Role::find($id);
        $res = $role->delete();
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
        $input = $request->input('ids');
        $res = Role::destroy($input);
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

    // 用户授权
    public function auth($id)
    {
        // 获取当前角色
        $role = Role::find($id);
        // 获取权限列表
        $perms = Permission::get();

        // 获取当前角色拥有的权限
        $own_perms = $role->permission;
        $own_pers = [];
        foreach($own_perms as $v){
            $own_pers[] = $v->id;
        }

        return view('admin.role.auth',compact('role','perms','own_pers'));
    }


    // 修改授权
    public function doAuth(Request $request)
    {
        $input = $request->except('_token');
        // dd($input);

        // 删除当前角色已有权限
        DB::table('role_permission')->where('role_id',$input['role_id'])->delete();
    
        // 添加修改后权限
        if (!empty($input['permission_id'])) {
            foreach ($input['permission_id'] as $v) {
                DB::table('role_permission')->insert(['role_id'=>$input['role_id'],'permission_id'=>$v]);
            }
        }

        return redirect('/admin/role');
    }
}
