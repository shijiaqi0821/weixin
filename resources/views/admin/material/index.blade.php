
@extends('layouts.show')
@section('title', '素材展示')
@section('content')
    <table class="table table-hover">
        <tr class="active">
            <td>素材名称</td>
            <td>素材图片</td>
            <td>素材格式</td>
            <td>素材类型</td>
            <td>素材时间</td>
            <td>过期时间</td>
        </tr>
        @foreach($data as $v)
        <tr class="success">
            <td>{{$v->media_name}}</td>
            @if($v->media_format == 'image')
                <td><img src="\{{$v->media_url}}" alt="" width="80"></td>
            @elseif($v->media_format == 'voice')
                <td><audio src="\{{$v->media_url}}" width="80" controls="controls"></audio></td>
            @elseif($v->media_format == 'video')
                <td><video src="\{{$v->media_url}}" width="140" controls="controls"></video></td>
            @endif
            <td>{{$v->media_format}}</td>
            <td>{{$v->media_type}}</td>
            <td>{{date('Y-m-d H:i:s',$v->add_time)}}</td>
            <td>{{date('Y-m-d H:i:s',$v->last_time)}}</td>
        </tr>
        @endforeach
    </table>
@endsection