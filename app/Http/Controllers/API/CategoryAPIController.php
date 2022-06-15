<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;
use App\Traits\ApiReponseTrait;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Repositories\CategoryRepository;
use App\Http\Resources\CategoryAPIResource;

class CategoryAPIController extends Controller
{
    use ApiReponseTrait;

    protected $categoryRepository;
    public function __construct()
    {
        $this->categoryRepository = resolve(CategoryRepository::class);
    }

    public function index(Request $request)
    {
        try {
            $data = $this->categoryRepository->getCategories($request);
            if ($data->count() <= 0) {
                throw new Exception('No category was found!');
            }
            Session::put('categories_count', $data->count());
            return CategoryAPIResource::collection($data);
        } catch(Exception $e) {
            Log::error(get_class($this) . '()->' . __FUNCTION__, [$e->getMessage()]);
            return $this->jsonResponse($e->getMessage(), $e->getCode());
        }
    }
}
