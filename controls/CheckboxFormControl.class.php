<?php


/**
 * Represents a checkbox
 * @ingroup Form
 */
class CheckboxFormControl extends OptionalValueFormControl
{
	/**
	 * @return CheckboxFormControl
	 */
	static function create($name, $label, $value)
	{
		return new self ($name, $label, $value);
	}

	function getType()
	{
		return 'checkbox';
	}
}

