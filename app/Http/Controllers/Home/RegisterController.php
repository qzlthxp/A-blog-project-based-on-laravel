<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\SMS\SendTemplateSMS;
use App\SMS\M3Result;
use App\Model\User;

class RegisterController extends Controller
{
    //邮箱注册
    public function register()
    {
        return view('home.emailregister');
    } 


    public function doRegister(Request $request)
    {
        
    }


    //手机注册
    public function phoneReg()
    {
        return view('home.phoneregister');
    }
    
    public function sendCode(Request $request)
    {
        $input = $request->except('_token');
        $num = $input['phone'];
        $code = rand(1000,9999);
        $arr = [$code,5];

        $templateSMS = new SendTemplateSMS();
        $M3Result = new M3Result();

        $M3Result = $templateSMS->sendTemplateSMS($num,$arr,1);

        session()->put('phonecode',$code);

        return $M3Result->toJson();
    }
    
    public function doPhoneRegister(Request $request)
    {
        $input = $request->except('_token');
        $phonecode = session()->get('phonecode');
        $username = $input['phone'];
        $password = $input['user_pass'];
        $code = $input['code'];
        $arr = [$username,$password];
        if($phonecode == $code){
            $res = User::create([
                'user_name'=>$username,
                'user_pass'=>$password,
            ]);
            if($res){
                session()->put($username,$arr);
                return redirect('/res/dologin');
            }else{
                return back()->with('msg','注册失败s');
            }   
        }else{
            return back()->with('msg','验证码无效');
        }
    }
}
