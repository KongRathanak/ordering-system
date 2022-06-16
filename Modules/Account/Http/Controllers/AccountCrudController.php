<?php

namespace Modules\Account\Http\Controllers;

use App\Traits\GetUserLoginTrait;
use App\Traits\SetPermissionTrait;
use App\Traits\ForceDeleteActionsTrait;
use Modules\Account\Http\Requests\AccountRequest;
use Modules\Account\Repositories\AccountRepository;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class AccountCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AccountCrudController extends CrudController {
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;

    public $trans = 'account::account.';

    use ForceDeleteActionsTrait;
    use SetPermissionTrait;
    use GetUserLoginTrait;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup() {
        CRUD::setModel(\Modules\Account\Entities\Account::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/account');
        CRUD::setEntityNameStrings('account', 'accounts');
        $this->setPermission();
        if (backpack_user()->canAccountReorder()) {
            CRUD::allowAccess(['reorder']);
        } else {
            CRUD::denyAccess(['reorder']);
        }

    }
    protected function setupReorderOperation() {
        // define which model attribute will be shown on draggable elements
        $this->crud->set('reorder.label', 'name');

        // define how deep the admin is allowed to nest the items
        // for infinite levels, set it to 0
        $this->crud->set('reorder.max_level', 4);
    }
    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        if(backpack_user()->canAccountExport()){
            $this->crud->enableExportButtons();
        }

        // filter by onlyTrashed
        if(backpack_user()->canAccountDelete()){
            $this->crud->addButtonFromModelFunction('line', 'btnForceRestoreDelete', 'btnForceRestoreDelete', 'end');
        }
        CRUD::addFilter(
            ['type' => 'simple', 'name' => 'trashed', 'label' => trans('Show Deleted')],
            false,
            function () {
             $this->crud->query->onlyTrashed();
         }
        );

        // column
        CRUD::addColumn([
            'name' => 'IdPrefix',
            'type' => 'text',
            'label' => trans($this->trans.'id'),
            'orderable'  => true,
            'orderLogic' => function ($query,$column, $columnDirection) {
                return $query->OrderByIdPrefix($columnDirection);
            },
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->IdPrefix($searchTerm, $column);
            }
        ]);
        CRUD::addColumn([
            'name' => 'name',
            'type' => 'text',
            'label' => trans($this->trans.'name'),
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhere(function ($q) use ($searchTerm) {
                    $q->SearchText($searchTerm);
                });
            }
        ]);
        CRUD::addColumn([
            'name' => 'industry',
            'type' => 'text',
            'label' => trans($this->trans.'industry')
        ]);
        CRUD::addColumn([
            'name' => 'ParentName',
            'type' => 'text',
            'label' => trans($this->trans.'parent_name')
        ]);
        CRUD::addColumn([
            'name' => 'address',
            'type' => 'text',
            'label' => trans($this->trans.'address')
        ]);
        CRUD::addColumn([
            'name' => 'phone',
            'type' => 'text',
            'label' => trans($this->trans.'phone')
        ]);
    }

    public function setupShowOperation() {
        $this->setupListOperation();
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(AccountRequest::class);

        $col6 = ['class' => 'form-group col-md-6'];

        CRUD::addField([
            'label'     => trans($this->trans.'contact'),
            'name'      => 'contact_id',
            'type'      => 'relationship',
            'entity' => 'contact',
            'attribute' => "FullName",
            'ajax'      => true,
            'minimum_input_length' => 2,
            'data_source'   => backpack_url("contact/fetch/contact"),
            'wrapper' =>  $col6
        ]);

        CRUD::addField([
            'name' => 'name',
            'type' => 'text',
            'wrapper' =>  $col6,
            'label' => trans($this->trans.'name')
        ]);

        CRUD::addField([
            'name' => 'industry',
            'type' => 'text',
            'wrapper' =>  $col6,
            'label' => trans($this->trans.'industry')
        ]);
        CRUD::addField([
            'name'          => 'parent_id',
            'label'         => trans($this->trans.'parent_name'),
            'data_source'   => route('web-api.ajax-nested'),
            'type'          => 'select2_ajax_nested',
            'entity'        => 'parent',
            'attribute'     => 'name',
            'placeholder'   => 'Select Parent',
            'minimum_input_length' => -1,
            'wrapper'       => $col6,
            'include_all_form_fields' => false,
            'self_parent' => true,
        ]);
        // CRUD::addField([
        //     'label'     => trans('Parent'),
        //     'name'      => 'parent_id',
        //     'type'      => 'relationship',
        //     'entity' => 'parent',
        //     'attribute' => "name",
        //     'ajax'      => true,
        //     'minimum_input_length' => -1,
        //     'data_source'   => backpack_url("account/fetch/account"),
        //     'wrapper' =>  $col6
        // ])
        CRUD::addField([
            'name' => 'address',
            'type' => 'text',
            'wrapper' =>  $col6,
            'label' => trans($this->trans.'address'),

        ]);
        CRUD::addField([
            'name' => 'phone',
            'type' => 'phone',
            'wrapper' =>  $col6,
            'label' => trans($this->trans.'phone'),
        ]);

    }

    public function store()
    {
        $response = $this->traitStore();
        $newEntry = $this->crud->entry;
        if($newEntry){
            resolve(AccountRepository::class)->addUserAndWallet($newEntry);
        }
        return $response;
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation() {
        $this->setupCreateOperation();
    }

    public function ajaxNested() {
        return resolve(AccountRepository::class)->ajaxNested(request());
    }
    public function fetchAccount() {
        $data = $this->crud->model->SearchText(request()->q);
        return [
            'data' => $data
                ->paginate(10)
                ->map(function ($v) {
                    return [
                        'id' => $v->id,
                        'name' => $v->name
                    ];
                })
        ];
    }
}
