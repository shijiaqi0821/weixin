@extends('layouts.show')
@section('title', '新闻添加')
@section('content')
    <h3>添加素材</h3>
    <hr>
    <form action="{{url('news/store')}}" method="post">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">标题</label>
            <input type="text" class="form-control" id="exampleInputEmail1" name="new_name" placeholder="标题">
        </div>

        <div class="form-group">
            <label for="exampleInputFile">内容</label>
            <textarea class="form-control" cols="30" rows="10" name="new_desc"></textarea>
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">作者</label>
            <input type="text" class="form-control" id="exampleInputEmail1" name="new_man" placeholder="作者">
        </div>

        <button type="submit" class="btn btn-default">添加</button>
    </form>
@endsection