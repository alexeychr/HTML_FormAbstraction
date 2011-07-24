<?php


/**
 * A set of strings
 * @ingroup Form
 */
class StringFormControlSet extends InputFormControlSet
{
	/**
	 * @return StringFormControlSet
	 */
	static function create($name, $label)
	{
		return new self ($name, $label);
	}

	protected function spawnControl()
	{
		return new StringFormControl($this->getInnerName(), $this->getLabel());
	}
}

