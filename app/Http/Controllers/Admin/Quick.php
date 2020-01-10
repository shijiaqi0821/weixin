<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tools\Wechat;
use App\Tools\Curl;
use App\Model\Quick as Quicks;


class Quick extends Controller
{
    //渠道添加
    public function create(){
        return view('admin.quick.create');
    }
    //执行添加
    public function store(){
        //接收所有值
        $data = request()->except('_token');
        //调用 微信生成带参数的二维码接口
        $access_token = Wechat::getAccessToken();
        //地址
        $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$access_token;
        //参数
        $postData = '{"expire_seconds": 2592000 , "action_name": "QR_STR_SCENE", "action_info": {"scene": {"scene_str": "'.$data['channel_status'].'"}}}';
        //发请求
        $ticket = json_decode(Curl::post($url,$postData),true);
        $ticket = $ticket['ticket'];
        //var_dump($ticket);die;
        //入库
        $res = Quicks::create([
            'channel_name'=>$data['channel_name'],
            'channel_status'=>$data['channel_status'],
            'ticket'=>$ticket,
        ]);
        if($res){
            echo "<script>alert('添加成功');location.href='/quick'</script>";
        }else{
            echo "<script>alert('添加失败');location.href='/quick/create'</script>";
        }
    }
    //渠道展示
    public function index(){
        $data = Quicks::get();
        return view('admin.quick.index',['data'=>$data]);
    }
    //图形展示
    public function graph(){
        $data = Quicks::get()->toArray();
        //dd($data);
        $xSty = "";
        $ySty = "";
        foreach($data as $k => $v){
            $xSty .= '"'.$v['channel_name'].'",';
            $ySty .= $v['number'].',';
        }
        $xSty = rtrim($xSty,',');
        $ySty = rtrim($ySty,',');

        return view('admin.quick.graph',['xSty'=>$xSty,'ySty'=>$ySty]);
    }
}
