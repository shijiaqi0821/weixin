<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Weather extends Controller
{
    public function create(){
//        $city = request()->city;
//
//        if(empty(request()->city)){
//            $city = "北京";
//        }
//        //调用K780接口,获取天气信息   appkey = 自己的
//        $url = "http://api.k780.com/?app=weather.future&weaid=".$city."&&appkey=47856&sign=6191833aede39d79b4711b973e3c3141&format=json";
//        //调用接口 (get/post)
//        $data = file_get_contents($url);
//        $data = json_decode($data,true);
//
//        $days = "";
//        foreach($data['result'] as $key => $value){
//            $days .= "'".$value['days']."',";
//        }
//        $days = rtrim($days,',');
//        dd($days);,['days'=>$days]

        return view('admin.weather.create');
    }


//    ================================================>
    public function index(){
        $city=request()->city;

        //北京 weatherData北京
        $cache_name='weatherData_'.$city;

        if(empty($data)){
            $url = "http://api.k780.com/?app=weather.future&weaid=".$city."&&appkey=47856&sign=6191833aede39d79b4711b973e3c3141&format=json";
            $data=file_get_contents($url);
            //缓存数据 只到当天的24点 （获取24点时间--当前时间）
            $time24=strtotime(date("Y-m-d"))+86400;
            $second=$time24-time();
        }

        //将调接口得到的json格式天气数据返回
        return $data;

    }
}
