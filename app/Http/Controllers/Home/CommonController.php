<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/16
 * Time: 19:56
 */

namespace App\Http\Controllers\Home;
use App\Http\Controllers\Controller;
use App\Http\Model\Article;
use App\Http\Model\Navs;
use Illuminate\Support\Facades\View;


class CommonController extends Controller {
     public function __construct() {
         $navs = Navs::orderBy('nav_id','asc')->get();

         //点击量最高的6篇文章
         $hot = Article::orderBy('art_view','desc')->take(5)->get();

         //最新发布文章8篇
         $new = Article::orderBy('art_time','desc')->take(8)->get();

         View::share('hot',$hot);
         View::share('new',$new);
         View::share('navs',$navs);
     }
}