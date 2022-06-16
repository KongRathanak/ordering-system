<?php

namespace App\Traits;

trait ApiResponser {

    protected function successResponse($data, $message = null, $code = 200) {
		return response()->json([
			'success' => true,
			'message' => $message,
			'code' => $code,
			'data' => $data
		], $code);
	}

	protected function errorResponse($message, $code) {
		return response()->json([
			'success' => false,
			'message' => $message,
			'code' => $code,
			'data' => []
		], $code);
	}

    protected function arrayResponse($message = '', $code = 400, $success = false, $data = []) {
		return [
			'message' => $message,
			'code' => $code,
            'success' => $success,
			'data' => $data
		];
	}

}
