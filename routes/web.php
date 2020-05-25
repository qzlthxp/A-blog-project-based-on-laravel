<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;
use Monolog\Handler\RotatingFileHandler;
// Route::get('/',function(){
//     return "Hello!";
// });



// 前台路由
Route::get('index','Home\IndexController@index');
Route::get('lists/{id}','Home\IndexController@lists');
Route::get('detail/{id}','Home\IndexController@detail');

//登录
Route::get('login','Home\LoginController@login');
Route::post('dologin','Home\LoginController@doLogin');
Route::post('res/dologin','Home\LoginController@ResdoLogin');
Route::get('loginout','Home\LoginController@loginOut');

// 文章收藏
Route::post('collect','Home\IndexController@collect');

// 邮箱注册激活路由
Route::get('emailregister','Home\RegisterController@register');
Route::post('doregister','Home\RegisterController@doRegister');

Route::get('active','Home\RegisterController@active');
Route::get('forget','Home\RegisterController@forget');
//发送密码找回邮件
Route::post('doforget','Home\RegisterController@doforget');
//重新设置密码页面
Route::get('reset','Home\RegisterController@reset');
//重置密码逻辑
Route::post('doreset','Home\RegisterController@doreset');

//手机注册页路由
Route::get('phoneregister','Home\RegisterController@phoneReg');
//发送手机验证码
Route::get('sendcode','Home\RegisterController@sendCode');
Route::post('dophoneregister','Home\RegisterController@doPhoneRegister');








Route::group(['prefix'=>'admin','namespace'=>'Admin',],function(){
    // 后台登陆页
    Route::get('login','LoginController@login');

    // 后台登录
    Route::post('dologin','LoginController@doLogin');

    // 验证码
    Route::get('code','LoginController@code');

});


Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>['islogin']],function(){
    
    // 后台首页
    Route::get('index','LoginController@index');

    // 后台欢迎页
    Route::get('welcome','LoginController@welcome');

    // 退出后台登陆
    Route::get('logout','LoginController@logout');

   
    // 用户模块相关路由
    Route::get('user/del','UserController@delAll');
    Route::get('user/{id}/editrole','UserController@editrole');
    Route::post('user/doeditrole','UserController@doeditrole');
    Route::resource('user','UserController');

    // 角色模块
    // 角色授权路由
    
    Route::get('role/auth/{id}','RoleController@auth');
    Route::post('role/doauth','RoleController@doAuth');
    Route::get('role/del','RoleController@delAll');
    Route::resource('role','RoleController');

    // 权限模块路由
    Route::get('permission/del','PermissionController@delAll');
    Route::resource('permission','PermissionController');

    // 分类模块路由
    Route::get('cate/del','CateController@delAll');
    Route::resource('cate','CateController');

    // 文章模块路由
    // 上传文件
    Route::post('article/upload','ArticleController@upload');
    Route::get('article/del','ArticleController@delAll');
    Route::resource('article','ArticleController');

    // 网站配置模块
    Route::post('config/changecontent','ConfigController@changeContent');
    Route::get('config/putcontent','ConfigController@putContent');
    Route::resource('config','ConfigController');


});

    // 没有权限
    Route::get('/noaccess','Admin\LoginController@noaccess');
