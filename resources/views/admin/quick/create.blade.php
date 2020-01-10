@extends('layouts.show')
@section('title', '渠道添加')
@section('content')
    <h3>添加渠道</h3>
    <hr>
    <form action="{{url('quick/store')}}" method="post">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">渠道名称</label>
            <input type="text" class="form-control" id="exampleInputEmail1" name="channel_name" placeholder="渠道名称">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">渠道标识</label>
            <input type="text" class="form-control" id="exampleInputEmail1" name="channel_status" placeholder="渠道标识">
        </div>

        <button type="submit" class="btn btn-default">添加</button>
    </form>
@endsection