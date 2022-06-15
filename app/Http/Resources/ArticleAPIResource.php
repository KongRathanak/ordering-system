<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleAPIResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $category = optional($this->category);
        $createdBy = optional($this->createdBy);
        $role = optional($createdBy->roles)->pluck('name')->implode(', ') . ', ' . optional($createdBy->articles)->count() . ' published post';
        return [
            'category' => $category->name,
            'date' => Carbon::parse($this->date)->format('F d, Y'),
            'category_link' => url('/articles' . '/' . $category->id),
            'link' => url('/article' . '/' . $this->id) ,
            'title' => $this->title,
            'content' => Str::words(strip_tags(preg_replace("/&#?[a-z0-9]+;/i", "", $this->content)), 30),
            'img' => $this->image ? asset($this->image) : '',
            'user' => [
                'name' => $createdBy->name,
                'img' => $createdBy->avatar ? asset($createdBy->avatar) : '',
                'role' => $role
            ]
        ];
    }
}
