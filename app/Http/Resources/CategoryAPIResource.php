<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryAPIResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $withArticles = $request->with_articles ?? false;
        $take = Session::get('categories_count') > 1 ? 3 : 6;
        $res = [
            'link' => url('/articles' . '/' . $this->id),
            'category' => $this->name,
        ];
        Session::flush('categories_count');

        if ($withArticles) {
            $res['articles'] = ArticleAPIResource::collection(optional($this->articles)->sortBy(['date', 'desc'])->take($take));
        }

        return $res;
    }
}
