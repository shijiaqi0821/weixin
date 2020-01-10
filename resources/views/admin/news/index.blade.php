@extends('layouts.show')
@section('title', '新闻展示')
@section('content')
    <h3>展示素材</h3><a href="{{url('/news/create')}}">添加</a>
    <hr>
    <form action="" method="" >
        <input type="text" class="col-sm-3" name="new_name" value="{{$info['new_name']??''}}" placeholder="请输入新闻标题关键字">&nbsp;
        <input type="text" class="col-sm-3" name="new_man" value="{{$info['new_man']??''}}" placeholder="请输入新闻作者关键字">&nbsp;
        <input type="submit" class="btn btn-warning" value="搜所">
    </form>
    <table class="table table-hover">
        <tr class="active">
            <td>新闻标题</td>
            <td>新闻内容</td>
            <td>新闻作者</td>
            <td>添加时间</td>
        </tr>
        @foreach($data as $v)
        <tr class="success">
            <td>{{$v->new_name}}</td>
            <td>{{$v->new_desc}}</td>
            <td>{{$v->new_man}}</td>
            <td>{{date('Y-m-d H:i:s',$v->add_time)}}</td>
        </tr>
        @endforeach
    </table>
    {{$data->appends($info)->links()}}
@endsection