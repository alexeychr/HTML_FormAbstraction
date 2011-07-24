<?php


/**
 * Represents a submit button
 * @ingroup Form
 */
class ButtonFormControl extends OptionalValueFormControl
{
	/**
	 * @return ButtonFormControl
	 */
	static function create($name, $label)
	{
		return new self ($name, $label);
	}

	function __construct($name, $label)
	{
		Assert::isNotEmpty($label, 'label should be specified');

		parent::__construct($name, $label, $label);
	}

	function getType()
	{
		return 'submit';
	}

	function toHtml(array $htmlAttributes = array())
	{
		Assert::isFalse(isset($htmlAttributes['name']));
		Assert::isFalse(isset($htmlAttributes['type']));
		Assert::isFalse(isset($htmlAttributes['value']));

		$htmlAttributes['name'] = $this->getName();
		$htmlAttributes['type'] = $this->getType();
		$htmlAttributes['value'] = $this->getFixedValue();

		return HtmlUtil::getNode('input', $htmlAttributes);
	}
}

