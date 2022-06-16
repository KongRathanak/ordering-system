<?php

namespace Modules\Type\Repositories;

use Modules\Type\Entities\Type;
use App\Repositories\BaseRepository;
use Modules\Type\Http\Resources\Types\TypeResource;
use Modules\Type\Http\Resources\Types\TypeBackEndResource;

/**
 * Class TypeRepository
 * @package App\Repositories\V1\Types
 * @version February 18, 2020, 1:22 am UTC
*/

class TypeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'parent_id',
        'lft',
        'rgt',
        'depth',
        'created_by',
        'updated_by'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable() {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model() {
        return Type::class;
    }

    /**
     * return value from database
     * @param array $name
     */
    public function getTypesByParentIDs($arr, $resource = true, $except = []) {
        $types = $this->model
            ->whereIn('parent_id', $arr)
            ->where(function ($q) use ($except) {
                if (is_array($except) && count($except)) {
                    $q->where($except);
                }
            })
            ->where('active', 1)
            ->orderBy('order', 'asc')
            ->get();

        if ($resource) {
            TypeResource::withoutWrapping();
            return TypeResource::collection($types);
        }

        TypeBackEndResource::withoutWrapping();
        return TypeBackEndResource::collection($types);
    }

}
