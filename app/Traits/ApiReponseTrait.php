<?php

namespace App\Traits;

trait ApiReponseTrait {

    public function jsonResponse($message, $code = 400, $success = false, $data = [])
    {
        $res = [
            'message' => $message,
            'success' => $success,
            'data' => $data,
        ];

        if (is_array($data) && count($data) <= 0) {
            unset($res['data']);
        }

        if ($code < 200 && $code > 600) {
            $code = 400;
        }

        return response()->json($res, $code);
    }
}
