@extends('layouts.show')
@section('title', '群发视图')
@section('content')
    <form action="{{url('/wechat/masstexting')}}" method="post">
        <textarea name="name" class="form-control" placeholder="请输入要发送的内容..."></textarea>
        <br>
        <button type="submit" class="btn btn-default">点击发送</button>
    </form>
@endsection