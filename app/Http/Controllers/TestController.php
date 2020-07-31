<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//引入Str类 随机字符串
use Illuminate\Support\Str;

class TestController extends Controller
{
    /**
     * 数据加密练习
     */
    public function enc(){
        //请求路径
        $url='http://api.1911.com/test/dec';
        //请求方式
        $method='AES-256-CBC';
        //请求key 密钥
        $key='1911api';
        //加密补全选项
        $options=OPENSSL_RAW_DATA;
        //初始化
        $iv='aaaabbbbccccdddd';
        //待加密数据
        $data='Hello Word';
        //openssl 加密
        $openssl_str=openssl_encrypt($data,$method,$key,$options,$iv);
        //使用base64加密
        $openssl_str=base64_encode($openssl_str);
        //url加密
        $openssl_str=urlencode($openssl_str);
        //拼接路径携带参数
        $enc_url=$url.'?data='.$openssl_str;
        //发送  获取
        $dec_str=file_get_contents($enc_url);
        echo $dec_str;
    }

    /**
     * 非对称加密
     */
    public function pubenc(){
        //待加密数据
        $data='非对称加密';
        //获取公钥
        $pubkey=file_get_contents(storage_path('key/api.pub.key'));
        //使用公钥进行加密
        openssl_public_encrypt($data,$enc_str,$pubkey,OPENSSL_PKCS1_PADDING);
        //base64加密
        $enc_str=base64_encode($enc_str);
        //加密路径
        $url='http://api.1911.com/test/pridec';
        //url加密
        $enc_str=urlencode($enc_str);
        //拼接路径
        $dec_url=$url.'?data='.$enc_str;
        //发送 请求
        $dec_str=file_get_contents($dec_url);
        echo $dec_str;
    }

    /**
     * 对向加密解密
     */
    public function encs(){
        //待加密数据
        $data='www项目发送api api解密';
        //获取api的公钥
        $apipub=file_get_contents(storage_path('key/api.pub.key'));
        //使用api公钥进行加密
        openssl_public_encrypt($data,$enc_str,$apipub,OPENSSL_PKCS1_PADDING);
        //base64进行加密
        $enc_str=base64_encode($enc_str);
        //url加密
        $enc_str=urlencode($enc_str);
        //发送路径
        $url='http://api.1911.com/test/decs';
        //拼接解密路径
        $dec_url=$url.'?data='.$enc_str;
        //发送 获取
        $dec_str=file_get_contents($dec_url);
        //转化数组
        $dec_str=json_decode($dec_str);
        //base64解密第一层
        $dec_str->api=base64_decode($dec_str->api);
        //获取www私钥
        $wpriv=file_get_contents(storage_path('key/www.priv.key'));
        //www私钥解密
        openssl_private_decrypt($dec_str->api,$dec_str->api,$wpriv,OPENSSL_PKCS1_PADDING);
        dd($dec_str);
    }

    /**
     * MD5()签名加密
     */
    public function sign1(){
        //公共key
        $key='api1911';
        //数据
        $data='MD5()签名';
        //生成签名
        $sign=md5($data.$key);
        //请求路径
        $url='http://api.1911.com/test/sign1';
        //拼接延签路径
        $signurl=$url.'?data='.$data.'&sign='.$sign;
        //请求 发送
        $response=file_get_contents($signurl);
        echo $response;
    }

    /**
     * 使用私钥生成签名
     */
    public function  privsign(){
        //待加密数据
        $data='Hello Word';
        //私钥
        $priv_key=file_get_contents(storage_path('key/www.priv.key'));
        //生成签名
        openssl_sign($data,$sign,$priv_key,OPENSSL_ALGO_SHA1);
        //使用base64加密
        $sign=base64_encode($sign);
        //使用urlencode加密
        $sign=urlencode($sign);
        //发送地址
        $url='http://api.1911.com/test/verify';
        //拼接
        $verifySign=$url.'?data='.$data.'&sign='.$sign;
        //发送 获取
        $verify=file_get_contents($verifySign);
        echo $verify;
    }

    /**
     * 数据对称加密+私钥加密签名
     */
    public function dataSign(){
        //待加密数据
        $data='www 数据对称加密+私钥加密签名 api验证';
        //加密算法
        $method='AES-256-CBC';
        //key 键
        $key='1911api';
        //加密补全选项
        $options=OPENSSL_RAW_DATA;
        //初始化向量
        $iv='aaaabbbbccccdddd';
        //加密
        $enc_str=openssl_encrypt($data,$method,$key,$options,$iv);
        //使用base64 加密
        $enc_str=base64_encode($enc_str);
        //url变换转义字符
        $enc_str=urlencode($enc_str);

        //获取私钥
        $priv_key=file_get_contents(storage_path('key/www.priv.key'));
        //签名私钥加密
        openssl_sign($data,$sign,$priv_key,OPENSSL_ALGO_SHA1);
        //base64加密签名
        $sign=base64_encode($sign);
        //url转义字符
        $sign=urlencode($sign);

        //发送地址
        $url='http://api.1911.com/test/datasign';
        //拼接发送地址
        $dec_url=$url.'?data='.$enc_str.'&sign='.$sign;
        //发送请求
        $response=file_get_contents($dec_url);
        echo $response;
    }

    /**
     * 使用header传值 给 api
     */
    public function header1(){
        //传值地址
        $url='http://api.1911.com/test/header1';
        //生成token 随机字符串
        $token=Str::random(32);
        //数据
        $header1=[
            'uid:112233',
            'token:'.$token
        ];
        //使用curl传值
        //初始化一个会话
        $ch=curl_init();
        //发送请求
        curl_setopt($ch,CURLOPT_URL,$url);
        //设置header值
        curl_setopt($ch,CURLOPT_HTTPHEADER,$header1);
        //执行一个会话
        curl_exec($ch);
        //关闭会话
        curl_close($ch);
    }

    /**
     * 支付页面
     */
    public function payview(){
        //渲染视图
        return view('pay');
    }

    /**
     * 支付
     */
    public function pay(){
        //接值 id
        $oid=request()->get('oid');

        //请求参数
        $param2=[
            'out_trade_no'   => time().mt_rand(10000,99999),
            'product_code'   => 'FAST_INSTANT_TRADE_PAY',
            'total_amount'   => 0.01,
            'subject'  => '1911API-测试订单-'.Str::random(16),
        ];

        //公共参数
        $param1=[
            'app_id'  => '2016102300743131',
            'method'  => 'alipay.trade.page.pay',
            'return_url'  => 'http://1911api.lvjingtao.top/alipay/return',
            'charset'  => 'utf-8',
            'sign_type'  => 'RSA2',
            'timestamp'  => date('Y-m-d H:i:s'),
            'version'  => '1.0',
            'notify_url'  => 'http://1911api.lvjingtao.top/alipay/notify',
            'biz_content'  => json_encode($param2),
        ];

        //计算签名
        ksort($param1);

        //拼接签名空字符串
        $str='';
        //循环获取参数
        foreach($param1 as $k=>$v){
            //循环拼接
            $str.=$k.'='.$v.'&';
        }
        //去除多余拼接符
        $str=rtrim($str,'&');
        //调用生成签名方法
        $sign=$this->sign($str);
        //跳转支付
        $url='https://openapi.alipaydev.com/gateway.do?'.$str.'&sign='.urlencode($sign);
        //跳转
        return redirect($url);
    }

    /**
     * 生成签名
     */
    protected function sign($data, $signType = "RSA")
    {
//        if ($this->checkEmpty($this->rsaPrivateKeyFilePath)) {
//            $priKey = $this->rsaPrivateKey;
//            $res = "-----BEGIN RSA PRIVATE KEY-----\n" .
//                wordwrap($priKey, 64, "\n", true) .
//                "\n-----END RSA PRIVATE KEY-----";
//        } else {
//            $priKey = file_get_contents($this->rsaPrivateKeyFilePath);
//            $res = openssl_get_privatekey($priKey);
//        }

        $priKey = file_get_contents(storage_path('key/ali.priv.key'));
        $res = openssl_get_privatekey($priKey);

        ($res) or die('您使用的私钥格式错误，请检查RSA私钥配置');

//        if ("RSA2" == $signType) {
//            openssl_sign($data, $sign, $res, OPENSSL_ALGO_SHA256);
//        } else {
//            openssl_sign($data, $sign, $res);
//        }
//
//        if (!$this->checkEmpty($this->rsaPrivateKeyFilePath)) {
//            openssl_free_key($res);
//        }
        openssl_sign($data, $sign, $res, OPENSSL_ALGO_SHA256);
        openssl_free_key($res);
        $sign = base64_encode($sign);
        return $sign;
    }
}
