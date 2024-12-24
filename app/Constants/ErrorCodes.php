<?php

namespace App\Constants;

class ErrorCodes
{
	const ERROR_CODE_SUCCESS = 0;
	const ERROR_CODE_INPUT_PARAM_ERROR = 1;
	const ERROR_CODE_DB_ERROR = 2;
	const ERROR_CODE_UPLOAD_FILE_IS_NOT_EXIST = 3;
}

class ErrorDescs {
	const ERROR_CODE_SUCCESS = '';
	const ERROR_CODE_INPUT_PARAM_ERROR = 'Input parameter error!';
	const ERROR_CODE_DB_ERROR = 'Database error!';
	const ERROR_CODE_UPLOAD_FILE_IS_NOT_EXIST = 'File does not exist!';
}
