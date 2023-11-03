<?php

namespace App\Http\Controllers\Admin\User;

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
        return view('admin.users.login',
        ['title' => 'Đăng nhập hệ thống ']);
    }

    public function store(LoginRequest $request)
    {
        //sử dụng Loginrequest đã custom
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];
        if (Auth::attempt($credentials)){
            return redirect()-> route('dashboard.index')->with('success','Đăng nhập thành công');
        }
        return redirect()->route('admin.users.login')->with('error','Email hoặc mật khẩu không chính xác');
    }
}
