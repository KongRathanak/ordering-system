<?php

namespace Modules\Account\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class UserConvertRequest extends FormRequest
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
            'password' => 'required|min:8|max:20|confirmed',
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator){
            $roles = request()->roles;
            if($roles == null || $roles == "[]"){
                $validator->errors()->add('roles', trans('the_roles_field_is_required'));
            }
        });
    }
}
