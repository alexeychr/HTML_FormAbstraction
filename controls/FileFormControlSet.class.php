<?php


/**
 * File set. Caveat: this set imports only succesfully uploaded files.
 *
 * TODO:
 *  - allow import of files with upload errors
 *  - introduce size/mime constraints
 *
 * @ingroup File
 */
class FileFormControlSet extends InputFormControlSet
{
	/**
	 * @return FileFormControlSet
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

	function importValue($value)
	{
		if (
				$value
				&& is_array($value)
				&& isset($value['name'])
				&& isset($value['tmp_name'])
				&& isset($value['error'])
				&& isset($value['size'])
		) {
			$fixed = array();
			foreach (array_keys($value['tmp_name']) as $idx) {
				if (!$value['error'][$idx]) {
					$fixed[$idx] = array(
						'name'     => $value['name'][$idx],
						'tmp_name' => $value['tmp_name'][$idx],
						'size'     => $value['size'][$idx],
						'error'    => $value['error'][$idx],
						'type'     => $value['type'][$idx],
					);
				}
			}

			$value = $fixed;
		}

		return parent::importValue($value);
	}

	protected function spawnControl()
	{
		return new FileFormControl($this->getInnerName(), $this->getLabel());
	}
}

