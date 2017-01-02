<?php
namespace App\Http\Controllers\Admin;
use App\Http\Model\Links;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LinksController extends CommonController {
    public function index() {
        $data = Links::orderBy('link_order','asc')->get();
       return view('admin/links/index',compact('data'));
    }


    //改变排序
    public function changeOrder() {
        $input = Input::all();
        if($input) {
            $cate = Links::find($input['link_id']);
            $cate->Link_order = $input['linkorder'];
            $res = $cate->save();
            if($res) {
                $data = [
                    'status'=>0,
                    'msg'=>'更新排序成功!',
                ];
                return $data;
            }else{
                $data = [
                    'status'=>1,
                    'msg'=>'更新排序失败!',
                ];
                return $data;
            }
        }
    }

    //展示分类排序页面
    public function create() {
        $data = [];
        return view('admin.links.add',compact('data'));
    }

    //提交文章数据post
    public function store() {
        if($input = Input::except('_token')) {
            $rules = [
                'link_name'=>'required',
            ];
            $message = [
                'link_name.required'=>'文章名称不得为空',
            ];
            $Validator = Validator::make($input,$rules,$message);
            if($Validator->passes()) {
                    $res = Links::create($input);
                    if($res) {
                        return redirect('admin/links');
                    }else {
                        return back()->with('error', '未知错误，请重试!');
                    }
                }else{
                    return back()->withErrors($Validator);
                //dd($Validator->errors()->all()); 打印错误信息
            }
        }
    }

    //get方式，category/id/edit,展示编辑页面
    public function edit($link_id) {
        $link = Links::find($link_id);
        return view('admin/links/edit',compact('link'));
    }

    //put方式，修改数据，提交到数据库
    public function update($link_id) {
       $input = Input::except('_token','_method');
        $res = Links::where('link_id',$link_id)->update($input);
        if($res) {
            return redirect('admin/links');
        }else {
            return back()->with('error','修改失败，请稍后再试!');
        }
    }

    //delete方法，删除分类
    public function destroy($link_id) {
       $res = Links::where('link_id',$link_id)->delete();
       if($res) {
           $data = [
             'status'=>0,
               'msg'=>'分类删除成功!',
           ];
           return $data;
       }else{
           $data = [
               'status'=>1,
               'msg'=>'分类删除失败',
           ];
           return $data;
       }
    }




}