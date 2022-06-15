<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title' => 'required|min:2|max:255',
            'slug' => 'unique:articles,slug',
            'content' => 'required|min:2',
            'date' => 'required|date',
            'status' => 'required',
            'category_id' => 'required',
        ];

        if (request()->has('operation') && request()->operation != 'create') {
            $rules['slug'] .= ',' . request()->id;
        }

        return $rules;
    }
}
