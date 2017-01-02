<?php
namespace App\Http\Controllers\Admin;
use App\Http\Model\User;
use Illuminate\Support\Facades\Input;

require_once 'resources/org/code/Code.class.php';
class LoginController extends CommonController {

    public function login()
    {
        if ($input = Input::all()) {
            $code = new \Code;
            $_code = $code->get();
            if(strtoupper($input['code']) != $_code) {
              return back()->with('msg','验证码错误!');
            }
            $user = User::first();
            if($user->user_name != $input['user_name'] || $user->user_pass != sha1($input['user_pass'])) {
                return back()->with('msg','用户名或者密码错误!');
            }
            session(['user'=>$user]);
            return redirect('admin/index');
        } else {
            if (session('user')) {
                return redirect('admin/index');
            } else {
                return view('admin/login');
            }
        }
    }

    public function code() {
        $code = new \Code;
        $code->make();
    }

    public function quit() {
        session(['user'=>null]);
        return redirect('admin/login');
    }


}