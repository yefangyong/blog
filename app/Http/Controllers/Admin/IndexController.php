<?php
namespace App\Http\Controllers\Admin;
use App\Http\Model\User;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class IndexController extends CommonController {
    public function index() {
        return view('admin/index');
    }

    public function info() {
        return view('admin/info');
    }

    //更改超级管理员的密码
    public function pass() {
        if($input = Input::all()) {
            $rules = [
                'password'=>'required|between:6,20|confirmed',
            ];
            $message = [
                'password.required'=>'新密码不得为空',
                'password.between'=>'新密码必须在6-20位之间!',
                'password.confirmed'=>'新密码与确认密码不一致!',
            ];

            $Validator = Validator::make($input,$rules,$message);
            if($Validator->passes()) {
                $user = User::first();
                if(sha1($input['password_o']) == $user->user_pass) {
                    $user->user_pass = sha1($input['password']);
                    $user->save();
                    return back()->with('error','密码修改成功!');
                }else{
                    return back()->with('error','原密码错误！');
                }
            }else{
                return back()->withErrors($Validator);
                //dd($Validator->errors()->all()); 打印错误信息
            }
        }else{
            return view('admin/pass');
        }
    }
}