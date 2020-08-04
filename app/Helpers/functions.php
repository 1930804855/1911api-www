<?php
    /**
     * 内容加密(非对称加密 base64加密 url加密)
     * @param $data 加密内容
     */
    function encode($data){
        //获取api项目的公钥 进行加密
        $api_pub=file_get_contents(storage_path('key/api.pub.key'));
        //公钥加密
        openssl_public_encrypt($data,$enc_str,$api_pub,OPENSSL_PKCS1_PADDING);
        //使用base64加密
        $enc_str=base64_encode($enc_str);
        return $enc_str;
    }

    /**
     * 签名加密(非对称加密 base64加密 url加密)
     * @param $data 生成签名的内容
     */
    function sign($data){
        //获取自己的私钥
        $www_priv=file_get_contents(storage_path('key/www.priv.key'));
        //生成签名
        openssl_sign($data,$sign,$www_priv,OPENSSL_ALGO_SHA1);
        //base64 加密
        $sign=base64_encode($sign);
        return $sign;
    }