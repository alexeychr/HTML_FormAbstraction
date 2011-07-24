<?php


/**
 * Represents an HTML <input> tag
 * @ingroup Form
 */
abstract class InputFormControl extends FormControlScalar
{
	/**
	 * Gets the type of an input
	 * @return string
	 */
	abstract function getType();

	function toHtml(array $htmlAttributes = array())
	{
		Assert::isFalse(isset($htmlAttributes['name']));
		Assert::isFalse(isset($htmlAttributes['type']));
		Assert::isFalse(isset($htmlAttributes['value']));

		$htmlAttributes['name'] = $this->getName();
		$htmlAttributes['type'] = $this->getType();
		$htmlAttributes['value'] = $this->getValue();

		return HtmlUtil::getNode('input', $htmlAttributes);
	}
}

