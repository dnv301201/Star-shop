<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserLoginController extends Controller
{
    public function index(){
        return view('users.login');
    }
    public function store(LoginRequest $request)
    {
        $remember = $request->has('remember') ? true : false;
        //sử dụng Loginrequest đã custom
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
            
        ];
        if (Auth::attempt($credentials,$remember)||($credentials)){
            if(Auth::check()){
                if(Auth::user()->role_as == 0){
                    $previousUrl = Session::pull('previous_url', route('users.index'));
                    return redirect()->intended($previousUrl)->with('success','Đăng nhập thành công');
                } else {
                    Auth::logout(); 
                    return redirect()->back()->with('error','Truy cập bị từ chối');
                }
            }
            else{
                return redirect()->back()->with('error', 'Tài khoản không tồn tại hoặc thông tin đăng nhập không đúng');
            }
        }
        return redirect()->route('user.login')
            ->withInput($request->except('password'))
            ->with('error', 'Email hoặc mật khẩu không chính xác');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('users.index')->with('success','Đăng xuất thành công'); 
    }
}
