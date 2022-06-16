<?php

namespace Modules\Type\Http\Resources\Types;

use Illuminate\Http\Resources\Json\JsonResource;

class TypeNestedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
        return [
            'value'  => $this->code,
            'text'  => $this->DynamicName,
            'parent_id' => $this->parent_id,
            'ios_class' => $this->ios_class,
            'android_class' => $this->android_class,
            'web_class' => $this->web_class,
            'description' => $this->description,
            'icon'  => $this->RealImage,
            'active'  => !$this->active ? false : true,
            'display_on_frontend' => !$this->display_on_frontend ? false : true,
            'require_authentication' => !$this->require_authentication ? false : true,
        ];
    }
}
