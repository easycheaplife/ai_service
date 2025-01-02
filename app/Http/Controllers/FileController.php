<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Constants\ErrorCodes;
use App\Constants\ErrorDescs;

class FileController extends Controller
{
	public function upload(Request $request)
	{
		if ($request->hasFile('file')) {
			$path = $request->file('file')->store('public/uploads');
			$this->res['data']['file_name'] = basename($path);
		}
		else
		{
			return $this->error_response($request->ip(),
				ErrorCodes::ERROR_CODE_UPLOAD_FILE_IS_NOT_EXIST, ErrorDescs::ERROR_CODE_UPLOAD_FILE_IS_NOT_EXIST);
		}
		return $this->res;
	}

	public function download($file_name)
	{
		$file_path = 'public/uploads/' . $file_name;
		if (Storage::exists($file_path)) {
			$file = Storage::path($file_path);
			return response()->download($file, $file_name);
		}
		return $this->error_response($file_name,
			ErrorCodes::ERROR_CODE_UPLOAD_FILE_IS_NOT_EXIST, ErrorDescs::ERROR_CODE_UPLOAD_FILE_IS_NOT_EXIST);
	}
}
