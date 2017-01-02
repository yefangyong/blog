<?php
namespace App\Http\Controllers\Admin;
use App\Http\Model\Navs;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class NavsController extends CommonController {
    public function index() {
        $data = Navs::orderBy('nav_order','asc')->get();
       return view('admin/navs/index',compact('data'));
    }


    //改变排序
    public function changeOrder() {
        $input = Input::all();
        if($input) {
            $cate = navs::find($input['nav_id']);
            $cate->nav_order = $input['navorder'];
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
        return view('admin.navs.add',compact('data'));
    }

    //提交文章数据post
    public function store() {
        if($input = Input::except('_token')) {
            $rules = [
                'nav_name'=>'required',
            ];
            $message = [
                'nav_name.required'=>'导航名称不得为空',
            ];
            $Validator = Validator::make($input,$rules,$message);
            if($Validator->passes()) {
                    $res = navs::create($input);
                    if($res) {
                        return redirect('admin/navs');
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
    public function edit($nav_id) {
        $nav = navs::find($nav_id);
        return view('admin/navs/edit',compact('nav'));
    }

    //put方式，修改数据，提交到数据库
    public function update($nav_id) {
       $input = Input::except('_token','_method');
        $res = navs::where('nav_id',$nav_id)->update($input);
        if($res) {
            return redirect('admin/navs');
        }else {
            return back()->with('error','修改失败，请稍后再试!');
        }
    }

    //delete方法，删除分类
    public function destroy($nav_id) {
       $res = navs::where('nav_id',$nav_id)->delete();
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