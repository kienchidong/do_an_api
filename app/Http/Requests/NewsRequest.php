<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
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
            'title' => 'bail|required|max:100',
            'cate' => 'bail|required|exists:cate_news,name',
            'summary' => 'bail|required|min:10|max:255',
            'content' => 'bail|required|min:50',
            'image' => 'bail|required',
            'tag' => 'bail|required',
        ];
    }
}
