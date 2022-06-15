<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;
use App\Traits\ApiReponseTrait;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\ArticleRepository;
use App\Http\Resources\ArticleAPIResource;

class ArticleAPIController extends Controller
{
    use ApiReponseTrait;

    protected $articleRepository;
    public function __construct()
    {
        $this->articleRepository = resolve(ArticleRepository::class);
    }

    public function feature(Request $request)
    {
        try {
            $data = $this->articleRepository->getFeatureArticles($request);
            if ($data->count() <= 0) {
                throw new Exception('No article was found!');
            }
            return $this->jsonResponse('Successfully retrieved articles.', 200, true, ArticleAPIResource::collection($data));
        } catch(Exception $e) {
            Log::error(get_class($this) . '()->' . __FUNCTION__, [$e->getMessage()]);
            return $this->jsonResponse($e->getMessage(), $e->getCode());
        }
    }

    public function index(Request $request)
    {
        try {
            $data = $this->articleRepository->getArticles($request);
            if ($data->count() <= 0) {
                throw new Exception('No article was found!');
            }
            return ArticleAPIResource::collection($data);
        } catch(Exception $e) {
            Log::error(get_class($this) . '()->' . __FUNCTION__, [$e->getMessage()]);
            return $this->jsonResponse($e->getMessage(), $e->getCode());
        }
    }
}
