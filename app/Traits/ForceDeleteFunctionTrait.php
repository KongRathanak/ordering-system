<?php

namespace App\Traits;

use Throwable;
use UnexpectedValueException;

trait ForceDeleteFunctionTrait {

    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation { destroy as taitDestroy; }

    public function destroy($id) {
        try {
            $this->crud->hasAccessOrFail('delete');
            $this->crud->setOperation('delete');

            $response = [
                'action' => 'delete',
                'success' => true,
            ];

            $entry = $this->crud->query->withTrashed()->findOrFail($id);

            if (request()->force_delete == 1) {
                $isDeleted = $entry->forceDelete();
            } else {
                $isDeleted = $entry->delete();
                if ($entry->hasAttribute('deleted_by')) {
                    $entry->deleted_by = backpack_user()->id;
                    $entry->save();
                }
            }

            if (!$isDeleted) {
                throw new UnexpectedValueException(request()->event_error_msg, 422);
            }

            if (request()->operation == 'show') {
                $response['redirect'] = url($this->crud->route);
                return response()->json($response);
            }

            return response()->json($response);
        } catch (Throwable $th) {
            $response['success'] = false;
            $response['message'] = $th->getMessage();
            return response()->json($response, 422);
        }
    }

}
