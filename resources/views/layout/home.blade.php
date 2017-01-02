<!doctype html>
<html>
<head>
    <meta charset="utf-8">
 @yield('info')
    <link href="/resources/views/home/css/base.css" rel="stylesheet">
    <link href="/resources/views/home/css/index.css" rel="stylesheet">
    <link href="/resources/views/home/css/style.css" rel="stylesheet">
    <link href="/resources/views/home/css/new.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="/resources/views/home/js/modernizr.js"></script>
    <![endif]-->
</head>
<body>
<header>
    <div id="logo"><a href="/"></a></div>
    <nav class="topnav" id="topnav">
        @foreach($navs as $k=>$v)
        <a href="{{$v->nav_url}}"><span>{{$v->nav_name}}</span><span class="en">{{$v->nav_alias}}</span></a>
        @endforeach
    </nav>
</header>
@section('content')
    <h3>
        <p>最新<span>文章</span></p>
    </h3>
    <ul class="rank">
        @foreach($new as $v)
            <li><a href="{{url('a/'.$v->art_id)}}" title="{{$v->art_title}}" target="_blank">{{$v->art_title}}</a></li>
        @endforeach
    </ul>
    <h3 class="ph">
        <p>点击<span>排行</span></p>
    </h3>
    <ul class="paih">
        @foreach($hot as $v)
            <li><a href="{{url('a/'.$v->art_id)}}" title="{{$v->art_title}}" target="_blank">{{$v->art_title}}</a></li>
        @endforeach
    </ul>
    @show
<footer>
    <p>{!! Config::get('web.copyright') !!}<a href="/">　{{Config::get('web.web_count')}}</a></p>
</footer>
<script src="/resources/views/home/js/silder.js"></script>
</body>
</html>
