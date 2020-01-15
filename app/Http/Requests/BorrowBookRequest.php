<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BorrowBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'pay_day' => 'required|date|after:4 day',
        ];
    }

    public function messages()
    {
        return "khong duoc muon sach qua 4 ngay!";
    }

}
