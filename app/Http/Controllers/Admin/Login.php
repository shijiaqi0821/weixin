<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use APP\Login as logins;
use DB;

class Login extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.login.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.login.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //接收所有值
        $post = $request->except('_token');

        $where = [
            ['name','=',$post['name']],
            ['pwd','=',$post['pwd']]
        ];
        $login=DB::table('login')->where($where)->first();

        //获取id
        $id =DB::table('login')->where('name','=',$post['name'])->value('id');
        //获取错误次数
        $error_num = DB::table('login')->where('name','=',$post['name'])->value('error_num');
        //获取(最后的)错误时间
        $last_error_time = DB::table('login')->where('name','=',$post['name'])->value('last_error_time');

        if(!empty($login)){
            //获取登录时间
            DB::table('login')->where($where)->update(['ctime'=>time()]);
            //清零 错误时间该为null
            DB::table('login')->where('id', $id)->update(['error_num' => 0, 'last_error_time' => null]);
            //存session
            session(['login'=>$login]);
            request()->session()->save();
            echo "<script>alert('登录成功');location.href='/login/index';</script>";
        }else{
            //密码错误
            $time = time();

            if (($time-$last_error_time)>=3600) {
                //错误次数改为1  错误时间改位当前时间
                $res =  DB::table('login')->where('id', $id)->update(['error_num' => 1, 'last_error_time' => $time]);
                if ($res) {
                    echo "<script>alert('账号或密码有误,你还有两次次机会');location.href='/login';</script>";
                }
            }
            if ($error_num >= 3) {
                $min = 60 - ceil(($time - $last_error_time) / 60);
                echo "<script>alert('账号或密码有误,请于 $min 分钟后登录');location.href='/login';</script>";
            } else {
                $res = DB::table('login')->where('id', $id)->update(['error_num' => $error_num + 1, 'last_error_time' => $time]);
                if ($res) {
                    $num = (3 - ($error_num + 1));
                    echo "<script>alert('账号或密码有误,你还有 $num 次机会');location.href='/login';</script>";
                }
            }
        }

        if($login==null){
            echo "<script>alert('账号不存在或密码错误');location.href='/login';</script>";
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('admin.login.index_v1');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
