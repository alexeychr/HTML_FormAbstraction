<?php


/**
 * A select drop-down menu
 * @ingroup Form
 */
final class SelectFormControl extends SetFormControl
{
	/**
	 * @return SelectFormControl
	 */
	static function create($name, $label)
	{
		return new self ($name, $label);
	}

	function setDefaultValue($value)
	{
		Assert::isTrue(
			!$value || in_array($value, $this->getAvailableValues()),
			'trying to set a default value that is out of options range'
		);

		return parent::setDefaultValue($value);
	}

	function importValue($value)
	{
		if (!in_array($value, $this->getAvailableValues())) {
			$value = null;
			$this->setError(FormControlError::invalid());
		}

		if (!$value && !$this->isOptional()) {
			$this->setError(FormControlError::missing());
		}

		return parent::importValue($value);
	}

	function toHtml(array $htmlAttributes = array())
	{
		Assert::isFalse(isset($htmlAttributes['name']));

		$htmlAttributes['name'] = $this->getName();

		return HtmlUtil::getContainer('select', $htmlAttributes, join("", $this->getOptions()));
	}
}

