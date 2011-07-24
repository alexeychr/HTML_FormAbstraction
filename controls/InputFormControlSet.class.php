<?php


/**
 * A set of strings
 * @ingroup Form
 */
abstract class InputFormControlSet extends FormControlSet
{
	/**
	 * @var bool
	 */
	private $importDuplicates = false;

	/**
	 * @var bool
	 */
	private $importEmpty = false;

	/**
	 * @return InputFormControl
	 */
	abstract protected function spawnControl();

	function __construct($name, $label)
	{
		parent::__construct($name, $label);

		// initialize correct internals
		$this->setDefaultValue(array());
	}

	/**
	 * Gets the inner controls
	 * @return IFormControl[]
	 */
	function getControls()
	{
		$yield = array();

		if ($this->isImported()) {
			foreach ($this->getImportedValue() as $value) {
				$control = $this->spawnControl();
				$control->importValue($value);

				Assert::isFalse(
					$control->hasError(),
					'cannot import value `%s` into %s: caused error `%s` %s',
					$value, get_class($control), (string) $control->getError(), $control->getErrorMessage()
				);

				$yield[] = $control;
			}

		}
		else {
			foreach ($this->getDefaultValue() as $value) {
				$control = $this->spawnControl();
				$control->setDefaultValue($value);

				$yield[] = $control;
			}
		}

		return $yield;
	}

	function setImportDuplicates($flag = true)
	{
		Assert::isBoolean($flag);

		$this->importDuplicates = $flag;

		return $this;
	}

	function getImportDuplicates()
	{
		return $this->importDuplicates;
	}

	function setImportEmpty($flag = true)
	{
		Assert::isBoolean($flag);

		$this->importEmpty = $flag;

		return $this;
	}

	function getImportEmpty()
	{
		return $this->importEmpty;
	}

	protected function setImportedValue($value)
	{
		Assert::isTrue(is_array($value));

		if (!$this->getImportDuplicates())
			$value = array_unique($value);

		if (!$this->getImportEmpty()) {
			$emptied = array();
			foreach ($value as $item) {
				if (!empty($item))
					$emptied[] = $item;
			}

			$value = $emptied;
		}

		return parent::setImportedValue($value);
	}
}

