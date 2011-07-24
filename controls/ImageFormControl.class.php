<?php


/**
 * Represents a file control
 * @ingroup File
 */
final class ImageFormControl extends FileFormControl
{
	private $allowedImageTypes = array(
		IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_JPEG2000, IMAGETYPE_PNG
	);

	private $minWidth = null;
	private $minHeight = null;

	/**
	 * @return ImageFormControl
	 */
	static function create($name, $label)
	{
		return new self ($name, $label);
	}

	function addAllowedType($type)
	{
		$this->allowedImageTypes[] = $type;

		return $this;
	}

	function setMinWidth($width = null)
	{
		$this->minWidth = $width;

		return $this;
	}

	function setMinHeight($height = null)
	{
		$this->minHeight = $height;

		return $this;
	}

	function addAllowedTypes(array $types)
	{
		foreach ($types as $type) {
			$this->addAllowedType($type);
		}

		return $this;
	}

	function setAllowedTypes(array $types)
	{
		$this
				->dropAllowedTypes()
				->addAllowedTypes($types);

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

	protected function setImportedValue($value)
	{
		if ($value) {
			try {
				$size = getimagesize($value['tmp_name']);
				if (
						$size
						&& $size[0]/*width*/
						&& $size[1]/*height*/
						&& in_array($size[2], $this->allowedImageTypes)
				) {
					if (
							   ($this->minWidth && $this->minWidth > $size[0])
							|| ($this->minHeight && $this->minHeight > $size[1])
					) {
						$this->setError(new FileFormControlError(FileFormControlError::TOO_SMALL));
						return;
					}

					parent::setImportedValue($value);
				}
				else {
					throw new Exception;
				};
			}
			catch (Exception $e) {
				$this->setError(new FileFormControlError(FileFormControlError::DISALLOWED_FILE_TYPE));
			}
		}
	}
}

