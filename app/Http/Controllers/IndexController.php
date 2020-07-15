<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * 获取access_token方法
     */
    public function getToken(){
        //appid
        $appid="wxb7f6d217acb5db86";
        //appsecret
        $appsec="7b31e98e4dee5bc700886582ba214c24";
        //获取access_token的接口
        $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsec;
        //获取
        $cont=file_get_contents($url);
        //输出
        echo $cont;
    }
}
