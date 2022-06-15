<?php

namespace App\Traits;

trait RolePermissionTrait {

    public $superAdmin = 1;
    public $admin = 2;
    public $editor = 3;
    public $user = 4;

    public function isSuperAdminRole() {
        return $this->hasAnyRole($this->superAdmin);
    }

    public function isAdminRole() {
        return $this->hasAnyRole($this->admin);
    }

    public function isEditorRole() {
        return $this->hasAnyRole($this->editor);
    }

    public function isUserRole() {
        return $this->hasAnyRole($this->user);
    }

    public function checkIfSuperAdmin()
    {
        if (!$this->isSuperAdminRole()) {
            abort(403);
        }
    }

}
