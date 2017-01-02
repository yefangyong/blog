<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CommonController extends Controller
{
    public function upload()
    {
        $file = Input::file('Filedata');
        if ($file->isValid()) {
            $entension = $file->getClientOriginalExtension();//上传文件的后缀名
            $newName = date('YmdHis') . mt_rand(100, 900) . '.' . $entension;  //重新命名文件
            $path = $file->move(base_path() . '/uploads', $newName);
            return 'uploads/'.$newName;
        }
    }
}