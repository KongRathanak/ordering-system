<?php

namespace Modules\Type\Http\Resources\Types;

use Illuminate\Http\Resources\Json\JsonResource;

class TypeIdResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $children = [];

        if (isset($this->children) && $this->children) {
            $children = $this->children->map(function ($value) {
                return [
                    'id'    => $value->id,
                    'code'  => $value->code,
                    'name'  => $value->DynamicName,
                    'ios_class' => $value->ios_class,
                    'android_class' => $value->android_class,
                    'web_class' => $value->web_class,
                    'description' => $value->description,
                    'icon'  => $value->RealImage,
                    'active'  => $value->active = 0 ? 'no' : 'yes',
                    'display_on_frontend' => $value->display_on_frontend = 0 ? 'no' : 'yes',
                    'require_authentication' => $value->require_authentication = 0 ? 'no' : 'yes'
                ];
            });
        }
        return $children;
    }
}
