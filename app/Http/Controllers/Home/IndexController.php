<?php
namespace App\Http\Controllers\Home;
use App\Http\Model\Article;
use App\Http\Model\Category;
use App\Http\Model\Links;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/16
 * Time: 19:54
 */
class IndexController extends CommonController {
    public function index() {

        //点击量最高的6篇文章（站长推荐）
        $pics = Article::orderBy('art_view','desc')->take(6)->get();

        //图文列表5篇（带分页）
        $data = Article::orderBy('art_time','desc')->paginate(5);

        //友情链接
        $links = Links::orderBy('link_order','asc')->get();

        return view('home.index',compact('hot','new','pics','data','links'));

    }

    public function cate($cate_id) {
        $cate = Category::find($cate_id);
        //图文列表5篇（带分页）

        Article::where('cate_id',$cate_id)->increment('art_view');

        $data = Article::where('cate_id',$cate_id)->orderBy('art_time','desc')->paginate(5);
        //子分类
        $submenu = Category::where('cate_pid',$cate_id)->get();
        return view('home.list',compact('cate','data','submenu'));
    }

    public function article($art_id) {
        $filed = Article::Join('category','article.cate_id','=','category.cate_id')->where('art_id',$art_id)->first();
        //查看次数增加
        Article::where('art_id',$art_id)->increment('art_view');
        $article['pre'] = Article::where('art_id','<',$art_id)->orderBy('art_id','desc')->first();
        $article['next'] = Article::where('art_id','>',$art_id)->orderBy('art_id','asc')->first();
        $data = Article::where('cate_id',$filed->cate_id)->orderBy('art_id','desc')->take(6)->get();
        return view('home.news',compact('filed','article','data'));
    }
}
