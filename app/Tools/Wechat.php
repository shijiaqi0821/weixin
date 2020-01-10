<?php

namespace App\Tools;
use Illuminate\Support\Facades\Cache;

//微信核心类
class Wechat
{
    const appId = "wxc22a745cff2aeda7";
    const appSerect = "3b68d4ba77ae8c12d04e57bd57e8ffc9";

    //封装
    public static function reponseText($xmlobj,$msg){
        //回复的文本消息
        echo"<xml>
              <ToUserName><![CDATA[".$xmlobj->FromUserName."]]></ToUserName>
              <FromUserName><![CDATA[".$xmlobj->ToUserName."]]></FromUserName>
              <CreateTime>".time()."</CreateTime>
              <MsgType><![CDATA[text]]></MsgType>
              <Content><![CDATA[".$msg."]]></Content>
          </xml>";
    }

    //微信接口调用凭证
    public static function getAccessToken(){
        //先判断缓存是否有数据
        $access_token = Cache::get('access_token');
        //有数据之家安返回
        if(empty($access_token)){
            //获取access_token(微信接口调用凭证)
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".self::appId."&secret=".self::appSerect;
            $data = file_get_contents($url);
            $data = json_decode($data,true);
            $access_token = $data['access_token'];  //token如何存储2小时

            Cache::put('access_token',$access_token,7200); // 120 分钟
        }
        //没有数据再进去调微信接口获取 => 存入缓存
        return $access_token;
    }

    //获取用户信息
    public static function getUserInfoByOpenId($xmlobj){
        $access_token=Self::getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$xmlobj->FromUserName."&lang=zh_CN";
        $data = file_get_contents($url);
        $data = json_decode($data,true);
        return $data;
    }
}
