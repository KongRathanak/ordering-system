<?php

namespace Modules\Account\Http\Requests;

use App\Http\Requests\Request;
use Modules\Account\Entities\Account;
use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        if(request()->segment(3)){
            return resolve(Account::class)->requestRulesBackPack(request(), 'update');
        }
        return resolve(Account::class)->requestRulesBackPack(request());

    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages() {
        return [
            //
        ];
    }
}
