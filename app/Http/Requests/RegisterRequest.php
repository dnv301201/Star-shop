<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' =>'required|email|unique:users,email',
            'password' =>'required|min:8|confirmed'
        ];
    }
    
    public function messages(): array
    {
        return [
            'name.required' => 'Bạn chưa nhập tên.',
            'email.required' => 'Bạn chưa nhập email.',
            'email.email'=> 'Email phải có dạng ví dụ abc@gmail.com.',
            'email.unique' => 'Địa chỉ email đã tồn tại trong hệ thống.',
            'password.required' =>'Bạn chưa nhập mật khẩu.',
            'password.min' =>'Mật khẩu quá ngắn.',
            'password.confirmed' => 'Trường xác nhận mật khẩu không khớp.'

        ];
    }

}
