<?php


/**
 * Multi-select drop down menu
 * @ingroup Form
 */
final class SelectMultiFormControl extends SetFormControl
{
	private $defaultValue;

	/**
	 * @return SelectMultiFormControl
	 */
	static function create($name, $label)
	{
		return new self ($name, $label);
	}

	function __construct($name, $label)
	{
		Assert::isTrue(
			preg_match(FormControlSet::NAME_PATTERN, $name),
			'name of a set should contain alphanumeric symbols, glyphs and underscored only'
		);

		parent::__construct($name, $label);
	}

	function setDefaultValue($value)
	{
		if ($value) {
			if (!is_array($value))
				$value = array($value);

			Assert::isTrue(
				sizeof($value) == sizeof(array_intersect($this->getAvailableValues(), $value)),
				'trying to set a default value that is out of options range'
			);
		}
		else
			$value = array();

		$this->defaultValue = $value;

		return $this;
	}

	function getSelectedValues()
	{
		return $this->getValue();
	}

	function getDefaultValue()
	{
		return $this->defaultValue;
	}

	function importValue($value)
	{
		if ($value && !is_array($value)) {
			$value = array();
			$this->setError(FormControlError::invalid());
		}

		if (!$value)
			$value = array();

		$value = array_intersect($this->getAvailableValues(), $value);

		if (!$value && !$this->isOptional()) {
			$this->setError(FormControlError::missing());
		}


		$this->setImportedValue($value);

		return !$this->hasError();
	}

	function toHtml(array $htmlAttributes = array())
	{
		Assert::isFalse(isset($htmlAttributes['name']));
		Assert::isFalse(isset($htmlAttributes['multiple']));

		$htmlAttributes['name'] = $this->getName() . '[]';
		$htmlAttributes['multiple'] = 'multiple';

		return HtmlUtil::getContainer('select', $htmlAttributes, join("", $this->getOptions()));
	}
}

