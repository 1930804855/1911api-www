<?php

namespace App\Http\Controllers\Mstore;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//引入第三方类库 guzzle
use GuzzleHttp\Client;

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
     * 注册页面
     */
    public function register(){
        //渲染视图
        return view('mstore/register');
    }

    /**
     * 执行登录
     */
    public function loginDo(){
        //接值
        $username=request()->username;
        $userpwd=request()->userpwd;
        //密码加密
        //$userpwd=encrypt($userpwd);
        //调用加密函数
        $username=encode($username);
        $userpwd=encode($userpwd);

        //调用生成签名函数
        $sign=sign($username.$userpwd);

        //发送请求地址
        $url='http://api.1911.com/mstore/loginDo';
        //使用guzzle发送请求
        //实例化
        $client=new Client();
        //发送请求
        $response = $client->request('POST',$url, [
            'form_params' => [
                'username' => $username,
                'userpwd' => $userpwd,
                'sign'  => $sign
            ]
        ]);
        //获取主题部分内容
        $body=$response->getBody();
        //转换结果类型
        $body=json_decode($body);
        //判断结果
        if($body->code==0){
            return redirect('mstore');
        }else{
            return back()->with('msg',$body->msg);
        }
    }

    /**
     * 执行注册
     */
    public function registerDo(){
        //接值
        $username=request()->username;
        $useremail=request()->useremail;
        $userpwd=request()->userpwd;
        //密码加密
        $userpwd=encrypt($userpwd);

        //数据加密
        $username=encode($username);
        $useremail=encode($useremail);
        $userpwd=encode($userpwd);

        //生成签名
        $sign=sign($username.$userpwd.$useremail);

        //发送请求
        //发送请求地址
        $url='http://api.1911.com/mstore/registerDo';
        //实例化
        $client=new Client();
        //发送
        $response = $client->request('POST',$url, [
            'form_params' => [
                'username' => $username,
                'useremail' => $useremail,
                'userpwd' =>  $userpwd,
                'sign' => $sign
            ]
        ]);
        //获取主题内容
        $body=$response->getBody();
        //转换结果类型
        $body=json_decode($body);
        //判断
        if($body->code==0){
            //注册成功 跳转登录页面
            return redirect('mstore/login');
        }else{
            //注册失败 提示
            return back()->with('msg',$body->msg);
        }
    }
}
