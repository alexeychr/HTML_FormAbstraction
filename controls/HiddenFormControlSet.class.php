<?php


/**
 * A set of hidden controls
 * @ingroup Form
 */
class HiddenFormControlSet extends InputFormControlSet
{
	/**
	 * @return HiddenFormControlSet
	 */
	static function create($name, $label)
	{
		return new self ($name, $label);
	}

	protected function spawnControl()
	{
		return new HiddenFormControl($this->getInnerName());
	}
}

