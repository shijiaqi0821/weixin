<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tools\Wechat as Wechats;
use App\Model\Newsy;
use App\Model\Media;
use App\Model\Quick;
use App\Model\Status;
use App\Tools\Curl;

class Wechat extends Controller
{
    private $student = [
        "小火锅",
        "大火锅",
        "自助烤肉",
        "串串香"
    ];

    public function index(){
        //提交按钮 微信服务器GET请求=> echostr  原样输出echostr即可
//        $echostr = request()->echostr;
//        echo $echostr;die;

        //接入完成之后,微信公众号内用户任何操作 温馨服务器=> POST形式XML格式 发送到url上
        $xml=file_get_contents("php://input");//接收原始的XML 或json数据流
        //写入文件
        file_put_contents("log.txt","\n".$xml,FILE_APPEND);

        //方便处理 xml=>对象
        $xmlobj = simplexml_load_string($xml);

//        <xml><ToUserName><![CDATA[gh_7a46f66badd9]]></ToUserName>
//            <FromUserName><![CDATA[ozhvnwQvD5BP7XMv6G2ZeHYOuhbE]]></FromUserName>
//            <CreateTime>1578381766</CreateTime>
//            <MsgType><![CDATA[event]]></MsgType>
//            <Event><![CDATA[subscribe]]></Event>
//            <EventKey><![CDATA[qrscene_112]]></EventKey>
//            <Ticket><![CDATA[gQG28DwAAAAAAAAAAS5odHRwOi8vd2VpeGluLnFxLmNvbS9xLzAyZFpFVmNJZXJmRDExYUctWE51YzcAAgSqMRReAwQAjScA]]></Ticket>
//        </xml>
        //如果关注
        if($xmlobj->MsgType=='event' && $xmlobj->Event=='subscribe'){
            //获取某渠道关注人数
            $eventKey = mb_substr($xmlobj->EventKey,8);

            $eventKey= Quick::where('channel_status',$eventKey)->first();
            Quick::where('channel_id',$eventKey['channel_id'])->update(['number'=>$eventKey['number']+1]);
            //关注时,获取用户基本信息
            $access_token = Wechats::getAccessToken();
            //dd($access_token);
            //获取用户信息
            $data = Wechats::getUserInfoByOpenId($xmlobj);
            //dd($data);
            $res = Status::where('openid',$data['openid'])->first();
            //dd($res);
            if($res){
                Status::where('openid',$data['openid'])->update(['is_del'=>1,'channel_status'=>$data['qr_scene_str']]);
            }else{
                Status::create([
                    'openid'=>$data['openid'],
                    'status_name'=>$data['nickname'],
                    'status_sex'=>$data['sex'],
                    'status_city'=>$data['country'].$data['province'].$data['city'],
                    'channel_status'=>$data['qr_scene_str'],
                ]);
            }

            $nickname = $data['nickname'];  //获取到用户名
            $sex = $data['sex'];  //获取到性别
            if($sex=='1'){
                $xing = "男士";
            }else{
                $xing = "女士";
            }

            $msg = "你好,".$nickname.$xing."欢迎关注本小店～";
            //回复的文本消息
            Wechats::reponseText($xmlobj,$msg);
        }
//        <xml>
//            <ToUserName><![CDATA[gh_7a46f66badd9]]></ToUserName>
//            <FromUserName><![CDATA[ozhvnwYq-leJgWk2q35sgruNB9OI]]></FromUserName>
//            <CreateTime>1578445402</CreateTime>
//            <MsgType><![CDATA[event]]></MsgType>
//            <Event><![CDATA[unsubscribe]]></Event>
//            <EventKey><![CDATA[]]></EventKey>
//        </xml>
        //取消关注
        if($xmlobj->MsgType=='event' && $xmlobj->Event=='unsubscribe'){
            //用户基本信息表==>修改状态
            Status::where('openid',$xmlobj->FromUserName)->update(['is_del'=>2]);
            //获取渠道标识
            $channel = Status::where('openid',$xmlobj->FromUserName)->first();

            //根据渠道标识表统计人数-1
            $res = Quick::where('channel_status',$channel['channel_status'])->first();
            if($res['channel_status']>0){
                Quick::where('channel_status',$res['channel_status'])->update(['number'=>$res['number']-1]);
            }else{
                Quick::where('channel_status',$res['channel_status'])->update(['number'=>0]);
            }
        }

        //如果用户发送的是文本
        if($xmlobj->MsgType=='text'){
            $content = trim($xmlobj->Content);
            if($content == '1'){
                //回复的文本消息
                Wechats::reponseText($xmlobj,"元旦想吃什么呀～");
            }elseif($content == '2'){
                //回复的文本消息
                Wechats::reponseText($xmlobj,"元旦想干什么呀～");
            }elseif($content == '3'){
                $msg = implode(',',$this->student);
                //回复的文本消息
                Wechats::reponseText($xmlobj,$msg);
            }elseif($content == '4'){
                shuffle($this->student);
                $msg = $this->student[0];
                //回复的文本消息
                Wechats::reponseText($xmlobj,$msg);
            }elseif(mb_strpos($content,"天气") !== false){    //strpos()获取一个字符串首次出现的位置  前面 + mb_ 是把汉子当成 1位(长度??);
                //回复天气
                $city = rtrim($content,"天气");   //rtrim() 去除字符串右边的  特殊符号\空格\自己写的
                if(empty($city)){
                    $city = "北京";
                }
                //调用K780接口,获取天气信息   appkey = 自己的
                $url = "http://api.k780.com/?app=weather.future&weaid=".$city."&&appkey=47856&sign=6191833aede39d79b4711b973e3c3141&format=json";
                //调用接口 (get/post)
                $data = file_get_contents($url);
                $data = json_decode($data,true);

                $msg = "";
                foreach($data['result'] as $key => $value){
                    $msg .= $value['days']."".$value['week']."".$value['citynm']."".$value['temperature']."".$value['weather']."".$value['wind']."".$value['winp']."\n";
                }
                Wechats::reponseText($xmlobj,$msg);
            }elseif($content == "最新新闻"){
                $msg = Newsy::orderBy('new_id','desc')->limit(1)->value('new_desc');
                //dd($msg);
                Wechats::reponseText($xmlobj,$msg);
            }elseif($n = mb_strpos($content,"新闻+") !== false){
                $city = mb_substr($content,$n+2);
                //echo $city;die;
                $msg = Newsy::where('new_name','like',"%$city%")->count();
                if($msg>0){
                    $msg = Newsy::where('new_name','like',"%$city%")->orderBy('new_id','desc')->limit(1)->value('new_name');
                    Wechats::reponseText($xmlobj,$msg);
                }else{
                    $msg = "暂无相关新闻";
                    Wechats::reponseText($xmlobj,$msg);
                }
            }
        }
        //如果用户发送的是图片
        if($xmlobj->MsgType=='image'){
            $res=Media::where('media_format','=','image')->get()->toArray();
            $arr=array_rand($res);
            $msg=$res[$arr]['wechat_media_id'];
            //dd($msg);
            echo "<xml>
                 <ToUserName><![CDATA[".$xmlobj->FromUserName."]]></ToUserName>
                 <FromUserName><![CDATA[".$xmlobj->ToUserName."]]></FromUserName>
                 <CreateTime>".time()."</CreateTime>
                 <MsgType><![CDATA[image]]></MsgType>
                 <Image>
                 <MediaId><![CDATA[".$msg."]]></MediaId>
                 </Image>
               </xml>";
        }
        //如果用户发送的是语音
        if($xmlobj->MsgType=='image'){
            $res=Media::where('media_format','=','image')->get()->toArray();
            $arr=array_rand($res);
            $msg=$res[$arr]['wechat_media_id'];
            //dd($msg);
            echo "<xml>
                 <ToUserName><![CDATA[".$xmlobj->FromUserName."]]></ToUserName>
                 <FromUserName><![CDATA[".$xmlobj->ToUserName."]]></FromUserName>
                 <CreateTime>".time()."</CreateTime>
                 <MsgType><![CDATA[image]]></MsgType>
                 <Image>
                 <MediaId><![CDATA[".$msg."]]></MediaId>
                 </Image>
               </xml>
               <xml>
  <ToUserName><![\".$xmlobj->FromUserName.\"]]></ToUserName>
  <FromUserName><![CDATA[fromUser]]></FromUserName>
  <CreateTime>12345678</CreateTime>
  <MsgType><![CDATA[voice]]></MsgType>
  <Voice>
    <MediaId><![CDATA[\".$msg.\"]]></MediaId>
  </Voice>
</xml>

";
        }
    }
    //自定义菜单
    public function menus(){
        //关注时,获取用户基本信息
        $access_token = Wechats::getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=$access_token";
        $postData = [
            "button"    => [
                [
                    "type"  => "location_select",
                    "name"  => "发送位置",
                    "key"   => "rselfmenu_2_0"
                ],
                [
                    "name"  => "发图",
                    "sub_button"    => [
                        [
                            "type"  => "scancode_push",
                            "name"  => "扫一扫",
                            "key"   => "scan111"
                        ],
                        [
                            "type"  => "pic_weixin",
                            "name"  => "微信相册发图",
                            "key"   => "rselfmenu_1_2",
                            "sub_button" => [ ]
                        ],
                        [
                            "type"  => "pic_photo_or_album",
                            "name"  => "拍照或者相册发图",
                            "key"   => "rselfmenu_1_1",
                            "sub_button"=> [ ]
                        ]
                    ]
                ],
            ]
        ];
        $postData = json_encode($postData,JSON_UNESCAPED_UNICODE);
        $data = Curl::post($url,$postData);
        var_dump($data);
    }
}