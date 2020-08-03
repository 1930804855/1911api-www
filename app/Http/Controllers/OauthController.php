<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//引入第三方类库 guzzle
use GuzzleHttp\Client;

class OauthController extends Controller
{
    /**
     * GitHub第三方登录测试
     */
    public function github(){
        //code
        $code=$_GET['code'];
        //调用方法获取token方法 根据code 换取token
        echo $this->token($code);
    }

    /**
     * 获取token
     */
    public function token($code){
        //client_id
        $client_id='e1aa3ded514cc9901ad5';
        //client_secret
        $client_secret='427038ca93842e28af85ff8ea3e34389c54d73e5';
        //请求地址
        $url='https://github.com/login/oauth/access_token';

        //数据数组
        $data=[
            'client_id'=>$client_id,
            'client_secret'=>$client_secret,
            'code'=>$code,
        ];

        //使用第三方类库guzzle发送请求
        //实例化
        $client=new Client();
        //发送请求
        $response=$client->request('POST',$url,[
            'form_params'=>[
                'client_id'=>$client_id,
                'client_secret'=>$client_secret,
                'code'=>$code,
            ]
        ]);
        $body = $response->getBody();
        echo $body;
    }
}
