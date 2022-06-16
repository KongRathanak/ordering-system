<?php

namespace App\Traits;

trait AccessorTrait {

    public function getListStatusAttribute() {
        $value = $this->{$this->isStatus ?? 'status'};

        if ($value) {
            return  '<span class="badge bg-success">' . trans('system.active') . '</span>';
        }

        return  '<span class="badge bg-danger">' . trans('system.inactive') . '</span>';
    }

}
