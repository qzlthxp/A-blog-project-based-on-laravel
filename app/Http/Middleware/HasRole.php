<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use App\Model\User;
use App\Model\Role;
use App\Model\Permission;

class HasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 获取当前请求的路由 对应的控制器方法名
        $route = Route::current()->getActionName();

        // 获取当前用户权限组
        $user = User::find(session()->get('user')->user_id);
        
        $roles = $user->role;
        $arr = [];
        foreach($roles as $v){
            $perms = $v->permission;
            foreach($perms as $perm){
                $arr[] = $perm->per_url;
            }          
        }

        // 去掉重复的权限
        $arr = array_unique($arr);

        // 判断当前请求路由对应的控制器方法名是否在当前用户拥有的权限列表中
        if(in_array($route,$arr)){
            return $next($request);
        }else{
           return redirect('/noaccess'); 
        }



        return $next($request);
    }
}
