<?php


/**
 * Image set
 *
 * @ingroup File
 */
class ImageFormControlSet extends FileFormControlSet
{
	private $allowedImageTypes = array(
		IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_JPEG2000, IMAGETYPE_PNG
	);

	/**
	 * @return ImageFormControlSet
	 */
	static function create($name, $label, $defaultInputCount = 1)
	{
		return new self ($name, $label, $defaultInputCount);
	}

	function __construct($name, $label, $defaultInputCount = 1)
	{
		Assert::isPositiveInteger($defaultInputCount);

		parent::__construct($name, $label);

		$this->setDefaultValue(array_fill(0, $defaultInputCount, null));
	}

	function addAllowedType($type)
	{
		$this->allowedImageTypes[] = $type;

		return $this;
	}

	function dropAllowedTypes()
	{
		$this->allowedImageTypes = array();

		return $this;
	}

	function getAllowedTypes()
	{
		return $this->allowedImageTypes;
	}

	function hasAllowedType($type)
	{
		return in_array($type, $this->allowedImageTypes);
	}

	protected function spawnControl()
	{
		return ImageFormControl::create($this->getInnerName(), $this->getLabel())
				->setAllowedTypes($this->allowedImageTypes);
	}
}

