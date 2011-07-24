<?php


/**
 * A password input field
 * @ingroup Form
 */
class PasswordFormControl extends InputFormControl
{
	/**
	 * @return PasswordFormControl
	 */
	static function create($name, $label)
	{
		return new self ($name, $label);
	}

	function getType()
	{
		return 'password';
	}
}

