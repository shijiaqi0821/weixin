<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Newsy;

class News extends Controller
{
    public function create(){
        return view('admin.news.create');
    }
    public function store(){
        //接收所有值
        $data = request()->except('_token');
        $data['add_time'] = time();
        $res = Newsy::create($data);
        if($res){
            echo "<script>alert('添加成功');location.href='/news'</script>";
        }else{
            echo "<script>alert('添加失败');location.href='/news/create'</script>";
        }
    }
    public function index(){
        $new_name = request()->new_name;
        $new_man = request()->new_man;
        $where = [];
        if($new_name){
            $where[] = ['new_name','like',"%$new_name%"];
        }
        if($new_man){
            $where[] = ['new_man','like',"%$new_man%"];
        }

        $pageSize = config('app.pageSize');
        $data = Newsy::where($where)->paginate($pageSize);
        $info = request()->all();
        return view('admin.news.index',['data'=>$data,'info'=>$info]);
    }
}
