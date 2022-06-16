<?php

namespace Modules\Account\Http\Controllers;

use App\Traits\GetUserLoginTrait;
use App\Traits\SetPermissionTrait;
use Modules\Account\Entities\Contact;
use App\Traits\ForceDeleteActionsTrait;
use Modules\Account\Http\Requests\ContactRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ContactCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ContactCrudController extends CrudController {

    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;
    use ForceDeleteActionsTrait;
    use SetPermissionTrait;
    use GetUserLoginTrait;

    public $trans = 'account::account.';
    private $typeRepo;
    private $options;
    public $modelMerchant = 'Modules\\Payment\\Entities\\Merchant';
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup() {
        CRUD::setModel(Contact::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/contact');
        CRUD::setEntityNameStrings('contact', 'contacts');
        $this->crud->setShowView('account::backpack.contacts.show');
        $this->setPermission();

        $typeRepoClass = 'Modules\\Type\\Repositories\\TypeRepository';
        if (class_exists($typeRepoClass)) {
            $this->typeRepo = resolve($typeRepoClass);
        }

        if ($this->typeRepo) {
            $this->options = collect($this->typeRepo->getTypesByParentIDs([4,2], false))->groupBy('parent_id');
        }
    }

    public function setupShowOperation() {
        if(backpack_user()->canContactConvert()){
            $this->crud->addButtonFromView('line', 'covert_to_user', 'button_convert_to_user', 'beginning');
        }
        if(backpack_user()->canContactHistory()){
            $this->crud->addButtonFromView('line', 'history', 'button_history', 'beginning');
        }
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation() {

        if(backpack_user()->canContactExport()){
            $this->crud->enableExportButtons();
        }

        CRUD::addFilter([
            'name'  => 'status',
            'type'  => 'dropdown',
            'label' => trans($this->trans.'status'),
          ], [
            1 => 'Active',
            0 => 'Inactive'
          ], function($value) {
            CRUD::addClause('where', 'status', $value);
        });

        CRUD::addFilter([
            'name'  => 'position',
            'type'  => 'select2',
            'label' => trans($this->trans.'position')
        ], function () {
            return $this->options ? $this->options[4]->pluck('text','value')->toArray() : [];
        }, function ($value) {
             // if the filter is active
            CRUD::addClause('where', 'position', $value);
        });
        // select2_ajax filter
        CRUD::addFilter([
            'name'        => 'account_id',
            'type'        => 'select2_ajax',
            'label' => trans($this->trans.'account'),
            'placeholder' => 'Pick a account',
            'minimum_input_length' => -1,
            'attribute'   => 'name'
        ],
        // the ajax route
        route("web-api.ajax-nested"),
        function($value) {
            // if the filter is active
            $this->crud->addClause('where', 'account_id', $value);
        });
        CRUD::addFilter([
            'name'  => 'user_id',
            'type'  => 'dropdown',
            'label' => trans($this->trans.'check_user'),
        ], [
            1 => 'User',
            0 => 'None-User'
        ], function($value) {
            if($value){
                CRUD::addClause('whereNotNull','user_id');
            }else{
                CRUD::addClause('whereNull','user_id');
            }
        });
        if(backpack_user()->canContactDelete()){
            $this->crud->addButtonFromModelFunction('line', 'btnForceRestoreDelete', 'btnForceRestoreDelete', 'end');
        }
        // filter by onlyTrashed
        CRUD::addFilter([
            'type' => 'simple',
            'name' => 'trashed',
            'label' => trans('Show Deleted')
         ],
            false,
            function () {
             $this->crud->query->onlyTrashed();
         }
        );

        // Column

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
            'name' => 'first_name',
            'type' => 'text',
            'label' => trans($this->trans.'first_name'),
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhere(function ($q) use ($searchTerm) {
                    $q->SearchText($searchTerm);
                });
            }
        ]);
        CRUD::addColumn([
            'name' => 'last_name',
            'type' => 'text',
            'label' => trans($this->trans.'last_name'),
        ]);
        CRUD::addColumn([
            'name' => 'phone',
            'type' => 'text',
            'label' => 'ID',
            'label' => trans($this->trans.'phone'),
        ]);
        CRUD::addColumn([
            'name' => 'email',
            'type' => 'text',
            'label' => 'ID',
            'label' => trans($this->trans.'email'),
        ]);
        CRUD::addColumn([
            'name' => 'address',
            'type' => 'text',
            'label' => 'ID',
            'label' => trans($this->trans.'address'),
        ]);
        CRUD::addColumn([
            'name'     => 'status',
            'label'    => trans($this->trans.'status'),
            'type'     => 'closure',
            'escaped' => false,
            'function' => function($entry) {
                return $entry->StatusHtml;
            }
        ],);
        CRUD::addColumn([
            'name' => 'position',
            'type' => 'text',
            'label' => trans($this->trans.'position'),
        ]);
        CRUD::addColumn([
            'name'  => 'AccountName',
            'label' =>trans($this->trans.'account'),
            'type' => 'closure',
            'escaped' => false,
            'function' => function ($entry) {
                $url = backpack_url("account/{$entry->account_id}/show");
                return "<a href=\"{$url}\">".optional($entry->account)->name."</a>";
            }
        ]);
        CRUD::addColumn([
            'name' => 'user_id',
            'type' => 'check',
            'label' => trans($this->trans.'user'),
        ]);
        CRUD::addColumn([
            'name' => 'CreatedByName',
            'type' => 'text',
            'label' => trans($this->trans.'created_by'),
        ]);
        CRUD::addColumn([
            'name' => 'updatedByName',
            'type' => 'text',
            'label' => trans($this->trans.'updated_by'),
        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation() {
        CRUD::setValidation(ContactRequest::class);
        $entry = $this->crud->getCurrentEntry() ?? null;

        $col6 = ['class' => 'form-group col-md-6'];
        CRUD::addField([
            'name' => 'first_name',
            'type' => 'text',
            'label' => trans($this->trans.'first_name'),
            'wrapper' =>  $col6
        ]);
        CRUD::addField([
            'name' => 'last_name',
            'type' => 'text',
            'label' => trans($this->trans.'last_name'),
            'wrapper' =>  $col6
        ]);
        CRUD::addField([
            'name' => 'email',
            'type' => 'text',
            'label' => trans($this->trans.'email'),
            'wrapper' =>  $col6
        ]);
        CRUD::addField([
            'name' => 'phone',
            'type' => 'phone',
            'label' => trans($this->trans.'phone'),
            'wrapper' =>  $col6
        ]);

        CRUD::addField([
            'name' => 'address',
            'type' => 'text',
            'label' => trans($this->trans.'address'),
            'wrapper' =>  $col6
        ]);
        CRUD::addField([
            'name' => 'position',
            'type' => 'select2_from_array',
            'options' => $this->options ? $this->options[4]->pluck('text','value') : [],
            'label' => trans($this->trans.'position'),
            'allows_null' => true,
            'wrapper' =>  $col6
        ]);
        CRUD::addField([
            'name'          => 'account_id',
            'label' => trans($this->trans.'account'),
            'data_source'   => route('web-api.ajax-nested'),
            'type'          => 'select2_ajax_nested',
            'entity'        => 'account',
            'attribute'     => 'name',
            'placeholder'   => 'Select Account',
            'minimum_input_length' => -1,
            'wrapper'       => $col6,
            'include_all_form_fields' => true,
            'self_parent' => true,
        ]);
        CRUD::addField([
            'label'       => trans($this->trans.'other').' '.trans($this->trans.'account'),
            'type'        => "select2_from_ajax_multiple",
            'name'        => 'other_accounts',
            'entity'      => 'account',
            'attribute'   => "name",
            'data_source' => route('web-api.ajax-nested'),
            'pivot'       => true,
            'include_all_form_fields' => true,
            'value' => $entry->other_accounts ?? [],

            'delay' => 500,
            'placeholder' => "Select Account",
            'minimum_input_length' => 2,
            'wrapper'       => $col6,
        ]);
        if (request()->merchant_id) {
            CRUD::addField([
                'name' => 'merchant_id',
                'type' => 'select2',
                'entity' => 'merchant',
                'model' => $this->modelMerchant,
                'label' => trans($this->trans.'merchant_name'),
                'wrapper' => $col6,
                'value' => request()->merchant_id
            ]);
        } else {
            if (isset(request()->id)) {
                $data = $this->crud->model->where('id', request()->id)->first();
                if (request()->merchant_id) {
                    CRUD::addField([
                        'name' => 'merchants_id',
                        'type' => 'select2',
                        'entity' => 'merchant',
                        'model' => $this->modelMerchant,
                        'label' => trans($this->trans.'merchant_name'),
                        'wrapper' => $col6,
                        'options' => (function ($query){
                            return $query->get();
                        }),
                    ]);
                    CRUD::addField([
                        'name' => 'merchant_id',
                        'type' => 'hidden',
                        'attributes' => ['hidden' => 'hidden'],
                        'value' =>  $data->merchant_id
                    ]);
                } else {
                    CRUD::addField([
                        'name' => 'merchant_id',
                        'type' => 'select2',
                        'entity' => 'merchant',
                        'model' => $this->modelMerchant,
                        'label' => trans($this->trans.'merchant_name'),
                        'wrapper' => $col6,
                    ]);
                }

            } else {
                CRUD::addField([
                    'name' => 'merchant_id',
                    'type' => 'select2',
                    'entity' => 'merchant',
                    'model' => $this->modelMerchant,
                    'label' => trans($this->trans.'merchant_name'),
                    'wrapper' => $col6,
                ]);
            }

        }
        CRUD::addField([
            'name'  => 'status',
            'label' => trans($this->trans.'status'),
            'type'  => 'switch_box',
            'default' => 1,
            'wrapper' => $col6,
        ]);

    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation() {
        $entry = $this->crud->getCurrentEntry();
        $this->setupCreateOperation();
        if($entry->user_id){
            $this->crud->removeField('status');
        }
    }

    public function store() {
        return $this->traitStore();
    }
    public function update() {
        return $this->traitUpdate();
    }
    public function fetchContact() {
        $data = $this->crud->model->SearchText(request()->q);
        return [
            'data' => $data
                ->paginate(10)
                ->map(function ($v) {
                    return [
                        'id' => $v->id,
                        'FullName' => $v->first_name.' '.$v->last_name
                    ];
                })
        ];
    }
}
