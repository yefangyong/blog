<?php
namespace App\Http\Controllers\Admin;
use App\Http\Model\Category;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CategoryController extends CommonController {
    public function index() {
        //静态方法直接类名调用Category::tree()
        $data = (new Category)->tree();
        return view('admin.category.index')->with('data',$data);
    }


    public function gettree($data)
    {
        $arr = array();
        foreach ($data as $k => $v) {
            if ($v->cate_pid == 0) {
                $data[$k]['_cate_name'] = $data[$k]['cate_name'];
                $arr[] = $data[$k];
                foreach ($data as $m => $n) {
                    if($n->cate_pid == $v->cate_id){
                        $data[$m]['_cate_name'] = '├─ ' . $data[$m]['cate_name'];
                        $arr[] = $data[$m];
                    }
                }
            }
        }
        return $arr;
    }

    //改变排序
    public function changeOrder() {
        $input = Input::all();
        if($input) {
            $cate = Category::find($input['cate_id']);
            $cate->cate_order = $input['cateorder'];
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
        $data = Category::where('cate_pid',0)->get();
        return view('admin.category.add',compact('data',$data));
    }

    //提交分类数据post
    public function store() {

        if($input = Input::except('_token')) {
            $rules = [
                'cate_name'=>'required',
            ];
            $message = [
                'cate_name.required'=>'分类名称不得为空',
            ];
            $Validator = Validator::make($input,$rules,$message);
            if($Validator->passes()) {
                    $res = Category::create($input);
                    if($res) {
                        return redirect('admin/category');
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
    public function edit($cate_id) {
        $data = Category::where('cate_pid',0)->get();
        $category = Category::find($cate_id);
        return view('admin/category/edit',compact('data','category'));
    }

    //put方式，修改数据，提交到数据库
    public function update($cate_id) {
       $input = Input::except('_token','_method');
        $res = Category::where('cate_id',$cate_id)->update($input);
        if($res) {
            return redirect('admin/category');
        }else {
            return back()->with('error','修改失败，请稍后再试!');
        }
    }

    //delete方法，删除分类
    public function destroy($cate_id) {
//        $re = Category::where('cate_pid',$cate_id)->get();
//        if($re) {
//            $data = [
//                'status'=>2,
//                'msg'=>'此分类有子分类,分类删除失败',
//            ];
//            return $data;
//        }

       $res = Category::where('cate_id',$cate_id)->delete();
        Category::where('cate_pid',$cate_id)->update(['cate_pid'=>0]);
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