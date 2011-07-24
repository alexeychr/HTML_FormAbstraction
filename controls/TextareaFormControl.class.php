<?php


/**
 * Textarea
 * @ingroup Form
 */
class TextareaFormControl extends FormControlScalar
{
	/**
	 * @return TextareaFormControl
	 */
	static function create($name, $label)
	{
		return new self ($name, $label);
	}

	function toHtml(array $htmlAttributes = array())
	{
		Assert::isFalse(isset($htmlAttributes['name']));

		$htmlAttributes['name'] = $this->getName();

		return HtmlUtil::getContainer('textarea', $htmlAttributes, htmlspecialchars($this->getValue()));
	}
}

