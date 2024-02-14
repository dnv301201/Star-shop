<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\RegisterRequest;

class UserRegisterController extends Controller
{
    public function index(){
        return view('users.register');
    }

    public function register(RegisterRequest $request)
    {
        // Validate dữ liệu đầu vào
        $validator = Validator::make($request->all(),$request->rules(), $request->messages());

        // Kiểm tra nếu dữ liệu không hợp lệ
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput($request->except('password'));
        }

        // Tạo người dùng mới
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        // Redirect hoặc thực hiện hành động sau khi đăng ký thành công
        return redirect()->route('users.index')->with('success','Đăng ký thành công');
    }
}