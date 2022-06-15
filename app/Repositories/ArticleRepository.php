<?php

namespace App\Repositories;

use App\Models\Article;

class ArticleRepository extends BaseRepository {

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
        return Article::class;
    }

    public function getArticles($request)
    {
        $perPage = $request->per_page ?? 10;
        return $this->model
            ->with(['createdBy', 'category'])
            ->Published()
            ->orderBy('date', 'DESC')
            ->paginate($perPage);
    }

    public function getFeatureArticles($request)
    {
        $limit = $request->limit ?? 10;
        $sortBy = $request->sort_by ?? 'updated_at';
        $sortDr = $request->sort_dr ?? 'DESC';

        return $this->model
            ->with(['createdBy', 'category'])
            ->where('featured', true)
            ->Published()
            ->orderBy($sortBy, $sortDr)
            ->limit($limit)
            ->get();
    }
}
