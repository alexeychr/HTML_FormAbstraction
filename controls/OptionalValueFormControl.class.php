<?php


/**
 * Represents a control that expects a fixed value or null from the outer world
 * @ingroup Form
 */
abstract class OptionalValueFormControl extends InputFormControl
{
	/**
	 * @var scalar
	 */
	private $value;

	function __construct($name, $label, $value)
	{
		Assert::isScalar($value);

		$this->value = $value;

		parent::__construct($name, $label);
	}

	function setDefaultValue($value)
	{
		Assert::isTrue(
			!$value || $value == $this->value,
			'trying to set a default value that is out of options range'
		);

		return parent::setDefaultValue($value);
	}

	/**
	 * A fixed value we expect from outer world
	 * @return mixed
	 */
	final function getFixedValue()
	{
		return $this->value;
	}

	final function isOptional()
	{
		return true;
	}

	final function markRequired()
	{
		Assert::isUnreachable('nonsense');
	}

	function toHtml(array $htmlAttributes = array())
	{
		Assert::isFalse(isset($htmlAttributes['name']));
		Assert::isFalse(isset($htmlAttributes['type']));
		Assert::isFalse(isset($htmlAttributes['value']));
		Assert::isFalse(isset($htmlAttributes['checked']));

		$htmlAttributes['name'] = $this->getName();
		$htmlAttributes['type'] = $this->getType();
		$htmlAttributes['value'] = $this->getFixedValue();
		if ($this->getValue())
			$htmlAttributes['checked'] = 'checked';

		return HtmlUtil::getNode('input', $htmlAttributes);
	}

	protected function setImportedValue($value)
	{
		if ($value !== null && $value != $this->getFixedValue()) {
			$value = null;
			$this->setError(FormControlError::invalid());
		}

		parent::setImportedValue($value);
	}
}

