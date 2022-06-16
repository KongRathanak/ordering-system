<?php

namespace Modules\Type\Http\Resources\Types;

use Illuminate\Http\Resources\Json\JsonResource;

class TypeConstructionResource extends JsonResource
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
            'text'  => $this->DynamicName //should use name text or Lable
        ];
    }
}
