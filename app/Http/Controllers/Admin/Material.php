<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tools\Wechat;
use App\Tools\Curl;
use App\Model\Media;

class Material extends Controller
{
    //展示视图
    public function index()
    {
        $data = Media::get();
        return view('admin.material.index',['data'=>$data]);
    }
    //添加视图
    public function create()
    {
        return view('admin.material.create');
    }
    //执行添加
    public function store(Request $request){
        //1.接值
        $data = $request->input();

        //2.文件上传
        $file = $request->file;
        if (!$request->hasFile('file')) {
            echo "报错";die;
        }
        $txt = $file->getClientOriginalExtension(); //获取到文件的后缀名. 例: jpg;
        $filename = md5(uniqid()).".".$txt;     //获得32位随机的名称  +  后缀名
        $filePath = $file->storeAs('images',$filename);

        //3.调用微信上传素材接口 把图片==>微信服务器
        $access_token = Wechat::getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token=".$access_token."&type=".$data['media_format'];
        $filePathObj = new \CURLFile(public_path()."/".$filePath); //curl 发送文件的时候  => CURLFile处理
            //var_dump($filePath);die;
        $postData = ['media'=>$filePathObj];
        $res = Curl::post($url,$postData);
        $res = json_decode($res,true);

        //4.入库
        if(isset($res['media_id'])){
            $media_id = $res['media_id'];   //微信返回素材id
            //添加
            //dd($media_id);
            $res = Media::create([
                'media_name'=>$data['media_name'],
                'media_format'=>$data['media_format'],
                'media_type'=>$data['media_type'],
                'media_url'=>$filePath,   //素材上传地址
                'wechat_media_id'=>$media_id,
                'add_time'=>time(),
                'last_time'=>time()+60*60*24*3,
            ]);
            //dd($res);
            if(!empty($res)){
                echo "<script>alert('添加成功');location.href='/material'</script>";
            }else{
                echo "<script>alert('添加失败');location.href='/material/create'</script>";
            }
        }
    }
    //编辑视图
    public function edit($id)
    {
        //
    }
    //执行修改
    public function update(Request $request, $id)
    {
        //
    }
    //执行删除
    public function destroy($id)
    {
        //
    }
}
