<?php
namespace App\Http\Controllers\Admin;
use App\Http\Model\config;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ConfigController extends CommonController {
    public function index() {
        $data =Config::orderBy('conf_order','asc')->get();
        foreach($data as $k=>$v) {
            switch($v->filed_type) {
                case 'input':
                    $data[$k]->_html = '<input type="text" class="lg" name="conf_content[]" value="'.$v->conf_content.'"/>';
                    break;
                case 'textarea':
                   $data[$k]->_html = '<textarea name="conf_content[]" class="lg" type="text">'.$v->conf_content.'</textarea>';
                    break;
                case 'radio':
                   $arr = explode(',',$v->filed_value);
                   $str = '';
                   foreach($arr as $m=>$n) {
                       $r = explode('|',$n);
                       $c = $v->conf_content == $r[0]?'checked':'';
                       $str.='<input type="radio" name="conf_content[]" value="'.$r[0].'" '.$c.'/>'.$r[1].'　';
                   }
                   $data[$k]->_html = $str;
                    break;
            }
        }
       return view('admin/config/index',compact('data'));
    }


    //改变排序
    public function changeOrder() {
        $input = Input::all();
        if($input) {
            $cate =Config::find($input['conf_id']);
            $cate->conf_order = $input['conforder'];
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

    /**
     * @return \Illuminate\Http\RedirectResponse
     * 把配置项写入文件
     */
    public function putFile() {
        $config = Config::pluck('conf_content','conf_name')->all();
        $path = base_path().'/config/web.php';
        $str = '<?php return '.var_export($config,true).';';
        file_put_contents($path,$str);

    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeContent() {
        $input = Input::all();
        foreach($input['conf_id'] as $k=>$v) {
            Config::where('conf_id',$v)->update(['conf_content'=>$input['conf_content'][$k]]);
        }
        $this->putFile();
        return back()->with('error','数据更新成功!');
    }

    //展示分类排序页面
    public function create() {
        $data = [];
        return view('admin.config.add',compact('data'));
    }

    //提交文章数据post
    public function store() {
        if($input = Input::except('_token')) {
            $rules = [
                'conf_name'=>'required',
            ];
            $message = [
                'conf_name.required'=>'标题名称不得为空',
            ];
            $Validator = Validator::make($input,$rules,$message);
            if($Validator->passes()) {
                    $res =Config::create($input);
                    if($res) {
                        $this->putFile();
                        return redirect('admin/config');
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
    public function edit($conf_id) {
        $conf =Config::find($conf_id);
        return view('admin/config/edit',compact('conf'));
    }

    //put方式，修改数据，提交到数据库
    public function update($conf_id) {
       $input = Input::except('_token','_method');
        $res =Config::where('conf_id',$conf_id)->update($input);
        if($res) {
            $this->putFile();
            return redirect('admin/config');
        }else {
            return back()->with('error','修改失败，请稍后再试!');
        }
    }

    //delete方法，删除分类
    public function destroy($conf_id) {
       $res =Config::where('conf_id',$conf_id)->delete();
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
    public function show() {

    }




}