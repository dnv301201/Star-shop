<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name'=>'required',
            'price'=>'required',
            'content'=>'required',
            'category_id'=>'required|not_in:0',
            'feature_image_path'=>'required',
            'image_path'=>'required',
            'tags'=>'required'
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Bạn chưa nhập tên sản phẩm.',
            'price.required' => 'Bạn chưa nhập giá sản phẩm.',
            'content.required' => 'Bạn chưa nhập nội dung sản phẩm.',
            'category_id.required' => 'Bạn chưa chọn danh mục chứa sản phẩm.',
            'category_id.not_in' => 'Vui lòng chọn một danh mục',
            'feature_image_path.required' => 'Bạn chưa chọn file ảnh đại diện sản phẩm.',
            'image_path.required' => 'Bạn chưa chọn file ảnh phụ sản phẩm.',
            'tags.required' => 'Bạn chưa nhập tags sản phẩm.'
        ];
    }
}
