<?php

namespace Modules\Type\Http\Resources\Types;

use Illuminate\Http\Resources\Json\JsonResource;

class TypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    private function data($children)
    {
        if ($children) {
            $arr = [];
            foreach ($children as $child) {
                if (!$child->display_on_frontend) {
                    continue;
                }

                $arr[] = [
                    'id' => $child->id,
                    'value'  => $child->code ?? $child->name,
                    'text'  => $child->DynamicName,
                    'parent_id' => $child->parent_id,
                    'order' => $child->order,
                    'ios_class' => $child->ios_class,
                    'android_class' => $child->android_class,
                    'web_class' => $child->web_class,
                    'description' => $child->description,
                    'icon'  => $child->RealImage,
                    'active'  => $child->active,
                    'display_on_frontend' => $child->display_on_frontend,
                    'require_authentication' => $child->require_authentication,
                    'depth' => $child->depth,
                    'name_khm' =>$child->name_khm,
                    'children' => $child->depth <= 3 ? $this->data(optional($child->children)->sortBy('order')) : []
                ];
            }
            return $arr;
        }
        return null;
    }

    public function toArray($request)
    {
        return [
            'value'  => $this->code,
            'text'  => $this->DynamicName,
            'parent_id' => $this->parent_id,
            'order' => $this->order,
            'ios_class' => $this->ios_class,
            'android_class' => $this->android_class,
            'web_class' => $this->web_class,
            'description' => $this->description,
            'icon'  => $this->RealImage,
            'active' => $this->active,
            'display_on_frontend' => $this->display_on_frontend,
            'require_authentication' => $this->require_authentication,
            'depth' => $this->depth,
            'name_khm' =>$this->name_khm,
            'children' => $this->depth <= 3 ? $this->data(optional($this->children)->sortBy('order')) : []
        ];
    }
}
