@extends('layouts.show')
@section('title', '渠道展示')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <h3>一周期为展示</h3>
    <form action="" method="">
        城市: <input type="text" name="city" id="city">
        <input type="button" value="搜索" id="search"> (城市名可以为拼音和汉字)
    </form>

    <script>
        $(function(){
            $.ajax({
                url:"{{url('/weather')}}",
                method:"GET",
                data:{city:"北京"},
                dataType:"json",
                success:function(res){
                    //展示天气图标
                    weather(res.result);
                }
            })
        })
        $('#search').on('click',function(){
            //城市名
            var city = $('#city').val();
            if(city==''){
                alert('内容不能为空');
            }
            //正则===>拼音和汉字
            var reg=/^[a-zA-Z]+$|^[\u4e00-\u9fa5]+$/;
            var res = reg.test(city);
            if(!res){
                alert('城市名只能是拼音和汉字');
                return;
            }
                $.ajax({
                    url:"{{url('/weather')}}",
                    method:"GET",
                    data:{city:city},
                    dataType:"json",
                    success:function(res){
                        //展示天气图标
                        weather(res.result);
                    }
                })
        })
            function weather(weatherDate){
                console.log(weatherDate);
                var categories = [];    //x轴日期
                var data = [];
                $.each(weatherDate,function(i,v){
                    categories.push(v.days);
                    var arr = [parseInt(v.temp_low),parseInt(v.temp_high)];
                    data.push(arr)
                })
                var chart = Highcharts.chart('container', {
                    chart: {
                        type: 'columnrange', // columnrange 依赖 highcharts-more.js
                        inverted: true
                    },
                    title: {
                        text: '每周温度变化范围'
                    },
                    subtitle: {
                        text: weatherDate[0]['citynm']
                    },
                    xAxis: {
                        categories: categories
                    },
                    yAxis: {
                        title: {
                            text: '温度 ( °C )'
                        }
                    },
                    tooltip: {
                        valueSuffix: '°C'
                    },
                    plotOptions: {
                        columnrange: {
                            dataLabels: {
                                enabled: true,
                                formatter: function () {
                                    return this.y + '°C';
                                }
                            }
                        }
                    },
                    legend: {
                        enabled: false
                    },
                    series: [{
                        name: '温度',
                        data: data
                    }]
                });
            }
    </script>

    <!-- 图表容器 DOM -->
    <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
    <!-- 引入 highcharts.js -->
    <script src="https://code.highcharts.com.cn/highcharts/highcharts.js"></script>
    <script src="https://code.highcharts.com.cn/highcharts/highcharts-more.js"></script>
    <script src="https://code.highcharts.com.cn/highcharts/modules/exporting.js"></script>
    <script src="https://img.hcharts.cn/highcharts-plugins/highcharts-zh_CN.js"></script>
@endsection