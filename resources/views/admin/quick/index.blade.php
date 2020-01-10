
@extends('layouts.show')
@section('title', '渠道展示')
@section('content')
    <table class="table table-hover">
        <tr class="active">
            <td>渠道ID</td>
            <td>渠道名称</td>
            <td>渠道标识</td>
            <td>渠道二维码</td>
            <td>关注人数</td>
        </tr>
        @foreach($data as $v)
        <tr class="success">
            <td>{{$v->channel_id}}</td>
            <td>{{$v->channel_name}}</td>
            <td>{{$v->channel_status}}</td>
            <td><img src="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket={{$v->ticket}}" alt="" width="80"></td>
            <td>{{$v->number}}</td>
        </tr>
        @endforeach
    </table>
@endsection