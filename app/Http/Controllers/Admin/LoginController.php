<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;


use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Termwind\Components\Dd;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    public function index(){
        return view('admin.login',
        ['title' => 'Đăng nhập hệ thống ']);
    }

    public function store(LoginRequest $request)
    {
        $remember = $request->has('remember') ? true : false;
        //sử dụng Loginrequest đã custom
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
            
        ];
        if (Auth::attempt($credentials,$remember)){
            if(Auth::check() && (Auth::user()->role_as == 1 || Auth::user()->role_as == 2)){
                return redirect()->route('admin.home')->with('success','Đăng nhập thành công');
            } else {
                return redirect()->route('admin.login')->with('error','Truy cập bị từ chối');
            }
            
        }
        return redirect()->route('admin.login')
            ->withInput($request->except('password'))
            ->with('error', 'Email hoặc mật khẩu không chính xác');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login')->with('success', 'Bạn đã đăng xuất thành công.');
    }

}
