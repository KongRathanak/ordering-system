<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait ForceDeleteTrait {

    public function btnForceRestoreDelete($crud) {
        $user = backpack_user();
        $delete = '';
        $entityName = $this->entityName ? $this->entityName : '';
        $cmCaseEtName = Str::studly($entityName);
        $permissionRestore = 'can' . $cmCaseEtName . 'Restore';
        $permissionFDelete = 'can' . $cmCaseEtName . 'ForceDelete';
        if ($this->deleted_at && (!method_exists($this, $permissionRestore) || $user->{$permissionRestore}())) {
            $delete .= view('vendor.backpack.crud.buttons.force_delete', [
                'crud' => $crud,
                'url' => route($entityName . '.restore', $this->id),
                'props' => ['button', 'restore_delete'],
            ]);
        }

        if (!method_exists($this, $permissionFDelete) || $user->{$permissionFDelete}()) {
            $delete .= view('vendor.backpack.crud.buttons.force_delete', [
                'crud' => $crud,
                'url' => route($entityName . '.destroy', $this->id),
                'props' => ['button', 'force_delete'],
            ]);
        }

        return $delete;
    }
}
