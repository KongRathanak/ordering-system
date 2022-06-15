<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository extends BaseRepository {

    /**
     * @var array
     */
    protected $fieldSearchable = [];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable() {
        return $this->fieldSearchable;
    }

    public function model()
    {
        return Category::class;
    }

    public function getCategories($request)
    {
        $perPage = $request->per_page ?? 10;
        return $this->model
            ->withCount('articles')
            ->whereHas('articles')
            ->orderBy('articles_count', 'DESC')
            ->paginate($perPage);
    }

}
