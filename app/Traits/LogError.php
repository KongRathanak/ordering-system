<?php
namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait LogError {

    public function logError($e, $class, $func) {
        Log::error('>>>>>>> Got error on class ' . $class . ' | function ' . $func . "<<<<<<<<\n", [$e]);
    }

    public function logErrorPayment($e, $class, $func) {
        Log::channel('payment')->error('>>>>>>> Payment got error on class ' . $class . ' | function ' . $func . "<<<<<<<<\n", [$e]);
    }

    public function checkErrorCode($code) {
        return is_numeric($code) && $code >= 400 && $code <= 510 ? $code : 401;
    }

}
