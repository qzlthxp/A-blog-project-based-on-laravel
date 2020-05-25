<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Model\User;
use App\Model\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * 获取列表页
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::orderBy('user_id','asc')
            ->where(function($query) use($request){
                    $username = $request->input('username');
                $email = $request->input('email');    //123@163.com
                $befemail = Str::before($email,'@');  //123
                $arfemail = Str::after($email,'@');    //163.com
               if(!empty($username)){
                   $query->where('user_name','like','%'.$username.'%'.'@'.'%'); 
               }
               if(!empty($email)){
                $query->where('email',$email)                   
                ->orwhere('email','like','%'.$email.'%'.'@'.'%')                           
                // ->orwhere('email','like','%'.$befemail.'%'.'@'.'%')       
                ->orwhere('email','like','%'.$befemail.'%'.'@'.$arfemail); 
               }

            })
            ->paginate($request->input('num')?$request->input('num'):5);
        return view('admin.user.list',compact('user','request'));
    }

    /**
     * 返回用户添加页面.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.user.add');
    }

    /**
     * 执行添加操作.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //接收前台表单提交的数据 email,pass,repass
        $input = $request->all();
        // 进行表单验证

        // 添加到数据库
        $username = $input['email'];
        $pass = Crypt::encrypt($input['pass']);

        $res = User::create(['user_name'=>$username,'user_pass'=>$pass,'email'=>$input['email']]);
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
     * 显示一条数据.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
       
    }

    /**
     * 返回一个修改页面.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $user = User::find($id);

        return view('admin.user.edit',compact('user'));
    }

    /**
     * 执行一个修改操作.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $user = User::find($id);
        $username = $request->input('username');
        $user->user_name = $username;
        $res = $user->save();
        if($res){
            $data = [
                'status'=>0,
                'message'=>'修改成功',
            ];
            
        }else{
            $data = [
                'status'=>1,
                'message'=>'修改失败',
            ];
        }
        return $data;
    }

    /**
     * 执行删除操作.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $user = User::find($id);
        $res = $user->delete();
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

        $res = User::destroy($input);
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


    // 用户添加角色
    public function editrole($id)
    {
        // 获取当前用户
        $user = User::find($id);
        // 获取角色列表
        $roles = Role::get();

        // 获取当前角色拥有的权限
        $own_roles = $user->role;
        $own_ros = [];
        foreach($own_roles as $v){
            $own_ros[] = $v->id;
        }

        return view('admin.user.editrole',compact('user','roles','own_ros'));
    }

    // 执行用户添加角色
    public function doeditrole(Request $request)
    {
        $input = $request->except('_token');
        // dd($input);

        // 删除当前角色已有权限
        DB::table('user_role')->where('user_id',$input['user_id'])->delete();
    
        // 添加修改后权限
        if (!empty($input['role_id'])) {
            foreach ($input['role_id'] as $v) {
                DB::table('user_role')->insert(['user_id'=>$input['user_id'],'role_id'=>$v]);
            }
        }

        return redirect('/admin/user');
    }
}
