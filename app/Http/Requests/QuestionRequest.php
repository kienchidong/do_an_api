<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
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
            'question' => 'bail|required',
            'answers' => [
                'bail', 'required', 'array',
                function ($attribute, $value, $fail) {
                    if (count(array_filter($value, function ($val) {
                            if ($val['value'] == true) {
                                return true;
                            }
                        })) < 2) {
                        return $fail('2 kết quả trở lên');
                    } elseif (count(array_filter($value, function ($val) {
                            if ($val['value'] == true) {
                                return true;
                            }
                        })) > 4) {
                        return $fail('4 kết quả thôi');
                    } elseif (count(array_filter($value, function ($val) {
                            if ($val['status'] == true) {
                                return true;
                            }
                        })) == 0) {
                        return $fail('mày chưa chọn kết quá đúng');
                    }
                }
            ],
        ];
    }
}
