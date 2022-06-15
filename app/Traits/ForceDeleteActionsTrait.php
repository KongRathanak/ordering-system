<?php

namespace App\Traits;

use App\Traits\ForceDeleteFunctionTrait;

trait ForceDeleteActionsTrait {

    use ForceDeleteFunctionTrait;

    public function restore($id) {
        $entry = $this->crud->query->withTrashed()->findOrFail($id);
        if ($entry->deleted_by) {
            $entry->deleted_by = null;
            $entry->save();
        }
        return response()->json([
            'action' => 'restore',
            'success' => $entry->restore() == 1 ? true : false,
        ]);
    }

}
