<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

trait SetPermissionTrait {

    public function setPermission() {
        try {
            $entityName = Str::plural($this->crud->model->entityName, 2);
            $user = backpack_user();
            $actions = [
                'list',
                'create',
                'update',
                'show',
                'delete',
                'clone',
                'bulkClone',
                'bulkDelete',
            ];

            $this->crud->denyAccess($actions);

            foreach ($actions as $action) {
                if ($action == 'bulkDelete') {
                    $action = 'delete';
                }
                if (in_array($action, ['clone', 'bulkClone'])) {
                    $action = 'create';
                }

                if ($user->hasPermissionTo("{$action} {$entityName}")) {
                    $this->crud->allowAccess($action);
                    if ($action == 'delete') {
                        $this->crud->allowAccess('bulkDelete');
                    }
                    if ($action == 'create') {
                        $this->crud->allowAccess('clone');
                        $this->crud->allowAccess('bulkClone');
                    }
                }
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

}
