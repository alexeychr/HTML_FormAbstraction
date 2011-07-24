<?php


/**
 * A string input
 * @ingroup Form
 */
class StringFormControl extends InputFormControl
{
	const MAIL_PATTERN 	= '/^[a-zA-Z0-9\!\#\$\%\&\'\*\+\-\/\=\?\^\_\`\{\|\}\~]+(\.[a-zA-Z0-9\!\#\$\%\&\'\*\+\-\/\=\?\^\_\`\{\|\}\~]+)*@[a-zA-Z0-9][\w\.-]*[a-zA-Z0-9]\.[a-zA-Z][a-zA-Z\.]*[a-zA-Z]$/Ds';
	const URL_PATTERN 	= '/^(http|https):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}((:[0-9]{1,5})?\/.*)?$/is';

	private $pattern;
	private $trim = true;

	/**
	 * @return StringFormControl
	 */
	static function create($name, $label)
	{
		return new self ($name, $label);
	}

	function setImportTrim($flag = true)
	{
		Assert::isBoolean($flag);

		$this->trim = $flag;

		return $this;
	}

    /**
     * Sets the PCRE pattern to check value against. If pattern check fails, FormControlError::WRONG is set.
     * @param $pattern
     * @return StringFormControl
     */
	function setPattern($pattern)
	{
		Assert::isScalar($pattern);

		$this->pattern = $pattern;

		return $this;
	}

	function getPattern()
	{
		return $this->pattern;
	}

	function setImportedValue($value)
	{
		if ($this->trim && !$this->hasError()) {
			$value = trim($value);
			if (!$value && !$this->isOptional()) {
				$this->setError(FormControlError::missing());
			}
		}

		if ($this->pattern && !$this->hasError()) {
			if (!preg_match($this->pattern, $value)) {
				$this->setError(FormControlError::wrong());
			}
		}

		parent::setImportedValue($value);
	}

	function getType()
	{
		return 'text';
	}
}

