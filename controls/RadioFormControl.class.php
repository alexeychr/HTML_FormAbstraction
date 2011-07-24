<?php


/**
 * Radio button
 * @ingroup Form
 */
class RadioFormControl extends OptionalValueFormControl
{
	/**
	 * @return RadioFormControl
	 */
	static function create($name, $label, $value)
	{
		return new self ($name, $label, $value);
	}

	function getType()
	{
		return 'radio';
	}
}

