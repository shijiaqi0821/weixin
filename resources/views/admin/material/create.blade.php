@extends('layouts.show')
@section('title', '素材添加')
@section('content')
    <h3>添加素材</h3>
    <hr>
    <form action="{{url('/material/store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">素材名称</label>
            <input type="text" class="form-control" id="exampleInputEmail1" name="media_name" placeholder="素材名称">
        </div>

        <div class="form-group">
            <label for="exampleInputFile">素材文件</label>
            <input type="file" class="form-control" name="file" id="exampleInputFile">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">素材类型</label>
            <select class="form-control" name="media_type" id="exampleInputEmail1">
                <option value="1">临时</option>
                <option value="2">永久</option>
            </select>
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">素材格式</label>
            <select class="form-control" name="media_format" id="exampleInputEmail1">
                <option value="image">图片</option>
                <option value="video">视频</option>
                <option value="voice">语音</option>
            </select>
        </div>

        <button type="submit" class="btn btn-default">添加</button>
    </form>
@endsection