<?php
namespace App\Http\Controllers\Admin;
use App\Http\Model\Article;
use App\Http\Model\Category;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ArticleController extends CommonController {
    public function index() {
        $data = Article::orderBy('art_id')->paginate(5);
       return view('admin.article.index',compact('data'));
    }

    //展示分类排序页面
    public function create() {
        $data = (new Category())->tree();
        return view('admin.article.add',compact('data'));
    }

    //提交分类数据post
    public function store() {
        $input = Input::except('_token');
        $input['art_time'] = time();
        $rules =[
            'art_title'=>'required',
            'art_content'=>'required',
        ];
        $message = [
            'art_title.required'=>'文章的标题不得为空!',
            'art_content.required'=>'文章的内容不得为空!',
        ];
        $Validator = Validator::make($input,$rules,$message);
        if($Validator->passes()) {
            $re = Article::create($input);
            if($re) {
                return redirect('admin/article');
            }else{
                return back()->with('error','文章添加失败!');
            }
        }else{
            return back()->withErrors($Validator);
        }


    }

    //get方式，category/id/edit,展示编辑页面
    public function edit($art_id) {
        $data = (new Category())->tree();
        $art = Article::find($art_id);
        return view('admin/article/edit',compact('data','art'));

    }

    //put方式，修改数据，提交到数据库
    public function update($art_id) {
        $input  = Input::except('_token','_method');
        $res = Article::where('art_id',$art_id)->update($input);
        if($res) {
            return redirect('admin/article');
        }else {
            return back()->with('error','修改失败，请稍后再试!');
        }
    }

    //delete方法，删除文章
    public function destroy($art_id) {
        $res = Article::where('art_id',$art_id)->delete();
        if($res) {
            $data = [
                'status'=>0,
                'msg'=>'文章删除成功!'
            ];
            return $data;
        }else {
            $data = [
                'status'=>1,
                'msg'=>'文章删除失败!'
            ];
            return $data;
        }
    }




}