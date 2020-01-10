<?php
//发送HTTP请求方式  file_get_contents()    curl

//curl   ====>  发送请求扩展库

//如何使用??  ===>  分为 4 步骤 !!!

//初始化       $curl = curl_init();
//设置         curl_setopt($curl, option, value);
//执行        $content = curl_exec($curl);
//关闭        curl_close($curl);ｊ

//GET方式
function curlGet($url){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);  //设置请求地址
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);  //返回数据格式
    //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    //curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    //curl_setopt($curl, CURLOPT_TIMEOUT,60);

    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}

//POST方式
function curlPost($url,$postData){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);  //设置请求地址
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);  //返回数据格式
    curl_setopt($url, CURLOPT_POST, 1); //设置以post发送
    curl_setopt($url, CURLOPT_POSTFIELDS, $postData);   //设置post发送数据
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);  //关闭HTTPS验证
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}

//调用GET实例
$url = "http://39.107.78.129";
$data = curlGet($url);



var_dump($output);die;