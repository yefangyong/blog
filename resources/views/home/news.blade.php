@extends('layout/home')
@section('info')
    <title>{{$filed->art_title}}--{{Config::get('web.web_title')}}</title>
    <meta name="keywords" content="{{$filed->art_tag}}" />
    <meta name="description" content="{{$filed->art_description}}" />
@endsection
@section('content')
<article class="blogs">
    <h1 class="t_nav"><span>您当前的位置：<a href="{{url('/')}}">首页</a>&nbsp;&gt;&nbsp;<a href="{{url('cate/'.$filed->cate_id)}}">{{$filed->cate_name}}</a></span><a href="{{url('/')}}" class="n1">网站首页</a><a href="{{url('cate/'.$filed->cate_id)}}" class="n2">{{$filed->cate_name}}</a></h1>
    <div class="index_about">
        <h2 class="c_titile">{{$filed->art_title}}</h2>
        <p class="box_c"><span class="d_time">发布时间：{{date('Y-m-d',$filed->art_time)}}</span><span>编辑：{{$filed->art_editor}}</span><span>查看次数：{{$filed->art_view}}</span></p>
        <ul class="infos">
            {!! $filed->art_content !!}
        </ul>
        <div class="keybq">
            <p><span>关键字词</span>：{{$filed->art_tag}}</p>

        </div>
        <div class="ad"> </div>
        <div class="nextinfo">
            <p>上一篇：
                @if($article['pre'])
                    <a href="{{$article['pre']->art_id}}">{{$article['pre']->art_title}}}}</a>
                @else
                    <span>没有下一篇了</span>
                @endif
            </p>
            <p>下一篇：
                @if($article['next'])
                    <a href="{{$article['next']->art_id}}">{{$article['next']->art_title}}}}</a>
                @else
                    <span>没有下一篇了</span>
                @endif
            </p>
        </div>
        <div class="otherlink">
            <h2>相关文章</h2>
            <ul>
                @if($data)
                    @foreach($data as $k=>$v)
                        <li><a href="{{url('a/'.$v->art_id)}}" title="{{$v->art_title}}">{{$v->art_title}}</a></li>
                    @endforeach
                @else
                        <span>没有相关文章</span>
                @endif
            </ul>
        </div>
    </div>
    <aside class="right">
        <!-- Baidu Button BEGIN -->
        <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare"><a class="bds_tsina"></a><a class="bds_qzone"></a><a class="bds_tqq"></a><a class="bds_renren"></a><span class="bds_more"></span><a class="shareCount"></a></div>
        <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585" ></script>
        <script type="text/javascript" id="bdshell_js"></script>
        <script type="text/javascript">
            document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
        </script>
        <!-- Baidu Button END -->
        <div class="blank"></div>
        <div class="news">
            @parent
    </aside>
</article>
@endsection