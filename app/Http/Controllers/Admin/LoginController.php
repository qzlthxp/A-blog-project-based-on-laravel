<?php

namespace App\Http\Controllers\Admin;

use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Org\code\Code;

use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Crypt;
class LoginController extends Controller
{
    //后台登录页
    public function login()
    {
        return view('admin.login');
    }
    
    
    //验证码
    public function code()
    {
        $code = new Code();
        return $code->make();
    }

  
    //处理用户登录到方法
    public function doLogin(Request $request)
    {

//        1. 接收表单提交的数据
        $input = $request->except('_token');

// //        2. 进行表单验证
// //        $validator = Validator::make('需要验证的表单数据','验证规则','错误提示信息');

//         $rule = [
//             'username'=>'required|between:4,18',
//             'password'=>'required|between:4,18|alpha_dash',
//         ];

//         $msg = [
//             'username.required'=>'用户名必须输入',
//             'username.between'=>'用户名长度必须在4-18位之间',
//             'password.required'=>'密码必须输入',
//             'password.between'=>'密码长度必须在4-18位之间',
//             'password.alpha_dash'=>'密码必须是数组字母下滑线',
//         ];
//         $validator = Validator::make($input,$rule,$msg);

//         if ($validator->fails()) {
//             return redirect('admin/login')
//                 ->withErrors($validator)
//                 ->withInput();
//         }


//        3. 验证是否由此用户（用户名  密码  验证码）
        if(strtolower($input['code']) != strtolower(session()->get('code'))){
            return ("<script>alert('验证码错误');location.href='login';</script>");
        }


        $user = User::where('user_name',$input['username'])->where('user_pass',$input['password'])->first();
        if(!$user){
            return ("<script>alert('用户名或密码错误');location.href='login';</script>");
        }

//      保存用户信息到session中

        session()->put('user',$user);

//      跳转到后台首页
        return redirect('admin/index');


        
        
        
    }   

  
    
    //后台首页
    public function index()
    {
        return view('admin.index');
    }


    // 后台欢迎页
    public function welcome()
    {
        return view('admin.welcome');
    }

    // 后台退出登录
    public function logout()
    {
        // 清空session中用户信息
        session()->flush();
        // 跳转到登录页面
        return redirect('admin/login');
    }


    // 没有权限
    public function noaccess()
    {
        return view('errors.noaccess');
    }

}
