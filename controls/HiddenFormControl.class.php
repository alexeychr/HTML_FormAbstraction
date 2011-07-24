<?php


/**
 * Represents a hidden value
 * @ingroup Form
 */
class HiddenFormControl extends InputFormControl
{
	/**
	 * @return HiddenFormControl
	 */
	static function create($name)
	{
		return new self ($name);
	}

	function __construct($name)
	{
		parent::__construct($name, 'hidden value ' . $name);
	}

	function getType()
	{
		return 'hidden';
	}
}

