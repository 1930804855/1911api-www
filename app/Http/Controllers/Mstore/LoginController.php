<?php

namespace App\Http\Controllers\Mstore;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * 登录页面
     */
    public function login(){
        //渲染视图
        return view('mstore/login');
    }

    /**
     * 执行登录
     */
    public function loginDo(){
        //接值
        $username=request()->username;
        $userpwd=request()->userpwd;
        dd($username,$userpwd);
    }
}
