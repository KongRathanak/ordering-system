<?php

namespace Modules\Type\Http\Requests\Types;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Type\Entities\Type;

class CreateTypeRequest extends FormRequest
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
        return Type::rulesTypesBackpack();
    }
}
