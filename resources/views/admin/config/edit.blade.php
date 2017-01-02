@extends('layout.admin')
@section('content')
        <!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 配置项管理
</div>
<!--面包屑导航 结束-->

<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>快捷操作</h3>
        @if(count($errors)>0)
            <div class="mark">
                @foreach($errors->all() as $error)
                    <p>{{$error}}</p>
                @endforeach
            </div>
        @endif
        @if(session('error'))
            <div class="mark">
                <p>{{session('error')}}</p>
            </div>
        @endif
    </div>
    <div class="result_content">
        <div class="short_wrap">
            <a href="{{url('admin/config/create')}}"><i class="fa fa-plus"></i>添加配置项</a>
            <a href="{{url('admin/config')}}"><i class="fa fa-recycle"></i>全部配置项</a>
        </div>
    </div>
</div>
<!--结果集标题与导航组件 结束-->

<div class="result_wrap">
    <form action="{{url('admin/config/'.$conf->conf_id)}}" method="post">
        <input type="hidden" name="_method" value="put"/>
        {{csrf_field()}}
        <table class="add_tab">
            <tbody>
            <tr>
                <th>标题：</th>
                <td>
                    <input type="text" name="conf_title" value="{{$conf->conf_title}}">
                    <span><i class="fa fa-exclamation-circle yellow"></i>配置项标题必须填写</span>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>名称：</th>
                <td>
                    <input type="text" class="lg" name="conf_name" value="{{$conf->conf_name}}">
                    <span><i class="fa fa-exclamation-circle yellow"></i>配置项名称必须填写</span>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>类型：</th>
                <td>
                    <input type="radio"  name="filed_type" value="input" @if($conf->filed_type == 'input') checked="checked" @endif onclick="showTr()">input　
                    <input type="radio"  name="filed_type" value="textarea" @if($conf->filed_type == 'textarea') checked="checked" @endif onclick="showTr()">textarea　
                    <input type="radio"  name="filed_type" value="radio" @if($conf->filed_type == 'radio') checked="checked" @endif onclick="showTr()">radio　
                </td>
            </tr>
            <tr class="filed_value">
                <th><i class="require">*</i>类型值：</th>
                <td>
                    <input type="text"  name="filed_value" checked="checked" value="{{$conf->filed_value}}">
                    <p><i class="fa fa-exclamation-circle yellow"></i>类型值只有在radio的情况下才需要配置 格式 1|开启 0|关闭</p>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>排序：</th>
                <td>
                    <input type="text" class="sm" name="conf_order" value="{{$conf->conf_order}}">
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>说明：</th>
                <td>
                    <textarea name="conf_content">{{$conf->conf_Content}}</textarea>
                </td>
            </tr>
            <tr>
                <th></th>
                <td>
                    <input type="submit" value="提交">
                    <input type="button" class="back" onclick="history.go(-1)" value="返回">
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>
<script>
    showTr();
    function showTr() {
        var type = $('input[name=filed_type]:checked').val();
        if(type == 'radio') {
            $('.filed_value').show();
        }else {
            $('.filed_value').hide();
        }
    }
</script>
@endsection