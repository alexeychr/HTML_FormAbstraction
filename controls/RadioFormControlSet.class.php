<?php


/**
 * Radio button group
 * @ingroup Form
 */
class RadioFormControlSet extends OptionFormControlSet
{
	private $defaultValue;
	private $importedValue;

	/**
	 * @return RadioFormControlSet
	 */
	static function create($name, $label)
	{
		return new self ($name, $label);
	}

	function setDefaultValue($value)
	{
		Assert::isScalar($value, 'default value shall be scalar');
		Assert::isTrue(
			in_array($value, $this->getAvailableValues()),
			'trying to set a default value that is out of options range'
		);

		$this->defaultValue = $value;

		return $this;
	}

	function getDefaultValue()
	{
		return $this->defaultValue;
	}

	protected function setImportedValue($value)
	{
		$this->importedValue = $value;

		parent::setImportedValue($value);
	}

	protected function getImportedValue()
	{
		return $this->importedValue;
	}

	function getSelectedValues()
	{
		$value = $this->getValue();
		return
				$value
					? array($value)
					: array();
	}

	function importValue($value)
	{
		if ($value && !is_scalar($value)) {
			$value = null;
			$this->setError(FormControlError::invalid());
		}
		else if (!in_array($value, $this->getAvailableValues())) {
			$value = null;
			$this->setError(FormControlError::invalid());
		}

		$this->setImportedValue($value);

		return !$this->hasError();
	}

	function getControls()
	{
		$yield = array();
		$checkedValue = $this->getValue();
		$isImported = $this->isImported();

		foreach ($this->getOptions() as $value => $label) {
			$yield[] = $control = new RadioFormControl($this->getName(), $label,
				$value);
			if ($checkedValue == $value) {
				if ($isImported)
					$control->importValue($value);
				else
					$control->setDefaultValue($value);
			}
		}

		return $yield;
	}
}

