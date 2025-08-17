<?php

namespace App\Constants;

class ErrorCodes
{
	const ERROR_CODE_SUCCESS = 0;
	const ERROR_CODE_INPUT_PARAM_ERROR = 1;
	const ERROR_CODE_DB_ERROR = 2;
	const ERROR_CODE_UPLOAD_FILE_IS_NOT_EXIST = 3;
	const ERROR_CODE_IMAGE_RECOGNITION_FAILED = 4;
	const ERROR_CODE_IMAGE_RECOGNITION_SERVICE_ERROR = 5;
	const ERROR_CODE_CHAT_FAILED = 6;
	const ERROR_CODE_CHAT_SERVICE_ERROR = 7;
	const ERROR_CODE_ESSAY_FAILED = 8;
	const ERROR_CODE_ESSAY_SERVICE_ERROR = 9;
}

class ErrorDescs {
	const ERROR_CODE_SUCCESS = '';
	const ERROR_CODE_INPUT_PARAM_ERROR = 'Input parameter error!';
	const ERROR_CODE_DB_ERROR = 'Database error!';
	const ERROR_CODE_UPLOAD_FILE_IS_NOT_EXIST = 'File does not exist!';
	const ERROR_CODE_IMAGE_RECOGNITION_FAILED = 'Image recognition failed!';
	const ERROR_CODE_IMAGE_RECOGNITION_SERVICE_ERROR = 'Image recognition service error!';
	const ERROR_CODE_CHAT_FAILED = 'Chat request failed!';
	const ERROR_CODE_CHAT_SERVICE_ERROR = 'Chat service error!';
	const ERROR_CODE_ESSAY_FAILED = 'Essay processing failed!';
	const ERROR_CODE_ESSAY_SERVICE_ERROR = 'Essay service error!';
}
