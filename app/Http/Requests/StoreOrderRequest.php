<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_name'  => 'required|string|max:100',
            'customer_phone' => 'required|regex:/^0[0-9]{9}$/',
            'order_type'     => 'required|in:delivery,pickup',
            'address'        => 'required_if:order_type,delivery|nullable|string|max:255',
            'note'           => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'customer_name.required'  => 'Vui lòng nhập họ tên.',
            'customer_phone.required' => 'Vui lòng nhập số điện thoại.',
            'customer_phone.regex'    => 'Số điện thoại phải có 10 chữ số và bắt đầu bằng 0.',
            'address.required_if'     => 'Vui lòng nhập địa chỉ giao hàng.',
        ];
    }
}