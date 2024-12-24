<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use App\Constants\ErrorCodes;

class Controller extends BaseController
{
	use AuthorizesRequests, ValidatesRequests;
	protected $res;

	function __construct() {
		$code = ErrorCodes::ERROR_CODE_SUCCESS;
		$this->res = array('code' => $code, 'message' => '', 'data' => array());
	}

	protected function error_response($request_id, $error_code, $error_message)
	{
		$this->res['code'] = $error_code;
		$this->res['message'] = $error_message;
		Log::error("$request_id " . $error_message);
		return $this->res;
	}
}
