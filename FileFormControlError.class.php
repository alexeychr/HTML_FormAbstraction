<?php


/**
 * @ingroup Form
 */
final class FileFormControlError extends FormControlError
{
	const MAX_SIZE_EXCEEDED = 'file exceeds the allowed size'; //UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE,
	const TOO_SMALL = 'file is empty';
	const UPLOAD_IS_PARTIAL = 'file was partially uploaded'; // UPLOAD_ERR_PARTIAL
	const DISALLOWED_FILE_TYPE = 'file of that type is not allowed'; // UPLOAD_ERR_EXTENSION

	// asserts: UPLOAD_ERR_NO_TMP_DIR, UPLOAD_ERR_CANT_WRITE

	static function maxSizeExceeded()
	{
		return new self (self::MAX_SIZE_EXCEEDED);
	}

	static function tooSmall()
	{
		return new self (self::TOO_SMALL);
	}

	static function uploadIsPartial()
	{
		return new self (self::UPLOAD_IS_PARTIAL);
	}

	static function disallowedFileType()
	{
		return new self (self::DISALLOWED_FILE_TYPE);
	}
}

