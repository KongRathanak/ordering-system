<?php

namespace Modules\Type\Http\Controllers;

use Carbon\Carbon;
use App\Traits\ForceDeleteActionsTrait;
use App\Traits\LogError;
use Prologue\Alerts\Facades\Alert;
use Illuminate\Support\Facades\Cache;
use Modules\Type\Repositories\TypeRepository;
use Modules\Type\Http\Requests\Types\CreateTypeRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Modules\Type\Entities\Type;

/**
 * Class TypeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TypeCrudController extends CrudController {

    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {
        store as traitStore;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation {
        update as traitUpdate;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation {
        storeInlineCreate as traitStoreInlineCreate;
    }

    use ForceDeleteActionsTrait;
    use LogError;

    protected $typeRepository;
    protected $labelCategory = 'type::type.category';
    protected $labelActive = 'type::type.active';

    public $typeName = 'type::type.name';
    public $typeCode = 'type::type.code';
    public $webClass  = 'type::type.web_class';
    public $adroidClass = 'type::type.android_class';
    public $iosClass = 'type::type.ios_class';
    public $typeDescription = 'type::type.description';
    public $typeOrder = 'type::type.order';
    public $requireAuthentication = 'type::type.require_authentication';
    public $displayONfrontend = 'type::type.display_on_frontend';

    protected function setupReorderOperation() {

        // define which model attribute will be shown on draggable elements
        $this->crud->set('reorder.label', 'name');
        // define how deep the admin is allowed to nest the items
        // for infinite levels, set it to 0
        $this->crud->set('reorder.max_level', 0);
    }

    public function setup()
    {
        if (!backpack_user()->isDeveloper()) {
            $this->crud->denyAccess(['create','list','show','update','delete']);
        }
        $this->isParentId = request()->parent_id ?? '';
        $this->crud->setModel(Type::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/type');
        $this->crud->setEntityNameStrings(trans('type::type.type'), trans('type::type.types'));
        $this->typeRepository = resolve(TypeRepository::class);
    }

    protected function setupShowOperation() {

        $this->crud->addColumn([
            'name' => 'name',
            'label'=> trans($this->typeName),
        ]);
        $this->crud->addColumn([
            'name' => 'code',
            'label'=> trans($this->typeCode),
        ]);
        $this->crud->addColumn([
            'name' => 'option',
            'label'=> trans('type::type.option'),
            'type'  => 'boolean',
        ]);
        $this->crud->addColumn([
            'name' => 'category',
            'label'=> trans('type::type.category'),
            'type'  => 'boolean',
        ]);
        $this->crud->addColumn([
            'name' => 'web_class',
            'label'=> trans($this->webClass),
        ]);
        $this->crud->addColumn([
            'name' => 'android_class',
            'label'=> trans($this->adroidClass),
        ]);
        $this->crud->addColumn([
            'name' => 'ios_class',
            'label'=> trans($this->iosClass),
        ]);
        $this->crud->addColumn([
            'name' => 'description',
            'label'=> trans($this->typeDescription),
        ]);

        $this->crud->addColumn([
            'name' => 'active',
            'label'=> trans('type::type.active'),
            'type'  => 'boolean',
        ]);
        $this->crud->addColumn([
            'name' => 'lft',
            'label'=> trans('type::type.lft'),
        ]);
        $this->crud->addColumn([
            'name' => 'rgt',
            'label'=> trans('type::type.rgt'),
        ]);
        $this->crud->addColumn([
            'name' => 'depth',
            'label'=> trans('type::type.depth'),
        ]);
        $this->crud->addColumn([
            'name' => 'order',
            'label'=> trans($this->typeOrder),
        ]);
        $this->crud->addColumn([
            'name' => 'created_by',
            'label'=> trans('type::type.created_by'),
        ]);
        $this->crud->addColumn([
            'name' => 'updated_by',
            'label'=> trans('type::type.updated_by'),
        ]);
        $this->crud->addColumn([
            'name' => 'require_authentication',
            'label'=> trans($this->requireAuthentication),
            'type'  => 'boolean',
        ]);
        $this->crud->addColumn([
            'name' => 'display_on_frontend',
            'label'=> trans($this->displayONfrontend),
            'type'  => 'boolean',
        ]);
        $this->crud->addColumn([
            'name' => 'display_on_backend',
            'label'=> trans('type::type.display_on_backend'),
            'type'  => 'boolean',
        ]);
        $this->crud->addColumn([
            'name' => 'created_at',
            'label'=> trans('type::type.created_at'),
            'type' => 'closure',
            'function' => function ($entry) {
                return Carbon::parse($entry->created_at)->format('j M Y, h:i A') ?? '-';
            }
        ]);
        $this->crud->addColumn([
            'name' => 'updated_at',
            'label'=> trans('type::type.updated_at'),
            'type' => 'closure',
            'function' => function ($entry) {
                return Carbon::parse($entry->updated_at)->format('j M Y, h:i A') ?? '-';
            }
        ]);
        $this->crud->removeColumns(['icon']);
        $this->crud->addColumn([
            'name' => 'IconSmall',
            'label' => "Icon",
            'type' => 'image',
            'height' => '50px',
            'width' => '50px',
        ]);
    }

    protected function setupListOperation() {

        // simple filter
        if ($this->isParentId) {
            $this->crud->addClause('where', 'parent_id', '=', $this->isParentId);
        } else {
            $this->crud->addClause('where', 'parent_id', '=', null);
        }

        $this->crud->addButtonFromModelFunction('line', 'btnForceRestoreDelete', 'btnForceRestoreDelete', 'end');

        $this->crud->addFilter([
            'type' => 'text',
            'name' => 'name',
            'label' => 'Name'
        ], false, function ($value) {
            $this->crud->addClause('SearchName', $value);
        });

        $this->crud->addFilter([
            'name' => 'parent_id',
            'type' => 'select2',
            'label'=> trans('type::type.parent')
        ], function () {
            return $this->crud->model->whereNull('parent_id')->orWhere('parent_id', 0)->pluck('name', 'id')->toArray();
        }, function ($value) {
            $this->crud->addClause('where', 'parent_id', $value);
        });

        $this->crud->addFilter([
            'type' => 'dropdown',
            'name' => 'category',
            'label'=> trans($this->labelCategory)
        ], [
            1 => 'Category'
        ], function ($value) {
            $this->crud->addClause('where', 'category',$value);
        });

        $this->crud->addFilter([
            'type' => 'dropdown',
            'name' => 'active',
            'label'=> trans($this->labelActive)
        ],[
            1 => 'Active',
            0 => 'Unactive',
        ],  function ($value) {
            $this->crud->addClause('where', 'active', $value);
        });

        $this->crud->addFilter(
            ['type' => 'simple', 'name' => 'trashed', 'label' => trans('type::type.show_deleted')],
            false,
            function () {
                $this->crud->query->onlyTrashed();
            }
        );

        $this->crud->addColumn([
            'name' => 'IdPrefix',
            'type' => 'text',
            'label' => trans('zpoin.id'),
            'orderable'  => true,
            'orderLogic' => function ($query,$column, $columnDirection) {
                return $query->OrderByIdPrefix($columnDirection,$column);
            },
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->IdPrefix($searchTerm, $column);
            }
        ]);
        $this->crud->addColumn([
            'name' => 'IconSmall',
            'label' => "Icon",
            'type' => 'image',
            'height' => '50px',
            'width' => '50px',
        ]);

        $this->crud->addColumn([
            'name' => 'code',
            'label' => trans($this->typeCode),
        ]);

        $this->crud->addColumn(
            [
                'label' => trans($this->typeName),
                'type' => "closure",
                'escaped' => false,
                'function' => function ($entry) {
                    return '<a href="' . backpack_url('type') . '?parent_id=' . $entry->id .'">'.$entry->name.'</a>';
                },
                'searchLogic' => function ($query, $column, $searchTerm) {
                    if ($column) {
                        $query->SearchName($searchTerm);
                    }
                }
            ]
        );

        $this->crud->addColumn([
            'label' => trans('type::type.parent'),
            'type' => "select",
            'name' => 'parent_id',
            'entity' => 'parent',
            'attribute' => "name",
            'model' => Type::class,
        ]);

        $this->crud->addColumn([
            'name' => 'order',
            'label' => trans($this->typeOrder),
            'type' => 'number'
        ]);

        $this->crud->addColumn([
            'name' => 'ios_class',
            'label' => trans($this->iosClass),
            'type' => 'text'
        ]);

        $this->crud->addColumn([
            'name' => 'android_class',
            'label' => trans($this->adroidClass),
            'type' => 'text'
        ]);

        $this->crud->addColumn([
            'name' => 'web_class',
            'label' => trans($this->webClass),
            'type' => 'text'
        ]);

        $this->crud->addColumn([
            'name' => 'category',
            'label' => trans($this->labelCategory),
            'type' => 'check'
        ]);

        $this->crud->addColumn([
            'name' => 'display_on_frontend',
            'label' => trans($this->displayONfrontend),
            'type' => 'check'
        ]);

        $this->crud->addColumn([
            'name' => 'require_authentication',
            'label' => trans($this->requireAuthentication),
            'type' => 'check'
        ]);

        $this->crud->addColumn([
            'name' => 'active',
            'label' => trans($this->labelActive),
            'type' => 'check'
        ]);

        $this->crud->addColumn([
            'name' => 'description',
            'label' => trans($this->typeDescription),
        ]);
    }

    protected function setupCreateOperation($type = '') {

        $colMd12 = ['class' => 'form-group col-md-12'];
        $colMd6 = ['class' => 'form-group col-md-6'];

        $this->crud->setValidation(CreateTypeRequest::class);

        $this->crud->addField([
            'name' => 'code',
            'label' => trans($this->typeCode),
            'wrapper' => $colMd6,
        ]);

        $this->crud->addField([
            'name' => 'name',
            'label' => trans($this->typeName),
            'wrapper' => $colMd6,
        ]);

        if ($this->isParentId && !$type) {
            $this->crud->addField([
                'name' => 'parent_id',
                'type' => 'hidden',
                'default' => $this->isParentId
            ]);
        }

        $this->crud->addField([
            'name' => 'order',
            'label' => trans($this->typeOrder),
            'type' => 'number',
            'wrapper' => $colMd6,
        ]);

        $this->crud->addField([
            'name' => 'ios_class',
            'label' => trans($this->iosClass),
            'wrapper' => $colMd6,
        ]);

        $this->crud->addField([
            'name' => 'android_class',
            'label' => trans($this->adroidClass),
            'wrapper' => $colMd6,
        ]);

        $this->crud->addField([
            'name' => 'web_class',
            'label' => trans($this->webClass),
            'wrapper' => $colMd6,
        ]);

        $this->crud->addField([
            'name' => '',
            'type' => 'hidden',
            'wrapper' => $colMd12,
        ]);

        $this->crud->addField([
            'name' => 'category',
            'label' => trans($this->labelCategory),
            'type' => 'checkbox',
            'wrapper' => $colMd6,
        ]);

        $this->crud->addField([
            'name' => 'active',
            'label' => trans($this->labelActive),
            'type' => 'checkbox',
            'default' => 1,
            'wrapper' => $colMd6,
        ]);

        $this->crud->addField([
            'name' => 'display_on_frontend',
            'label' => trans($this->displayONfrontend),
            'type' => 'checkbox',
            'wrapper' => $colMd6,
        ]);

        $this->crud->addField([
            'name' => 'require_authentication',
            'label' => trans($this->requireAuthentication),
            'type' => 'checkbox',
            'wrapper' => $colMd6,
        ]);

        $this->crud->addField([
            'name' => 'description',
            'label' => trans($this->typeDescription),
            'type' => 'textarea',
            'attributes' => ['rows' => '5']
        ]);

        $this->crud->addField([
            'label' => trans('type::type.icon'),
            'name' => "icon",
            'type' => 'image',
            'disk' => 'uploads',
            'upload' => true,
            'crop' => true,
            'aspect_ratio' => 1,
            'default' => 'assets/default.png',
            'wrapper' => $colMd6,
        ]);
    }

    protected function setupUpdateOperation() {

        $this->setupCreateOperation('update');

    }

    public function store() {

        $parentId = $this->isParentId ? $this->typeRepository->findParent($this->isParentId) : '';
        if (!$parentId) {
            Alert::error(trans('type::type.something_went_wrong'))->flash();
            return redirect(backpack_url('type/create?parent_id=' . $this->isParentId))->withInput();
        }
        $response = $this->traitStore();
        // Clear all cache when user udpated type
        Cache::flush();
        return $response;
    }

    public function update() {

        try {
            $response = $this->traitUpdate();
            // Clear all cache when user udpated type
            Cache::flush();
            return $response;
        } catch (\Exception $e) {
            $this->logError($e, get_class($this), __FUNCTION__);
        }
    }

    public function storeInlineCreate() {

        $result = $this->store();
        // do not carry over the flash messages from the Create operation
        Alert::flush();
        return $result;
    }
}
