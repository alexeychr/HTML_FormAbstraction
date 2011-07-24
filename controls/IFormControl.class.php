<?php


/**
 * Rather tight form element interface
 *
 *  - selectmulti (scalar impl) - array
 *  - radio group (array impl) - scalar
 *
 *
 * @ingroup Form
 */
interface IFormControl
{
	/**
	 * gets the name of a control
	 * @return string
	 */
	function getName();

	/**
	 * gets the label of a control
	 * @return string
	 */
	function getLabel();

	/**
	 * tries to import the value
	 * @param mixed $value
	 * @return boolean whether import was successful or not (caused import errors)
	 */
	function importValue($value);

	/**
	 * sets the default value
	 * @param mixed $value
	 * @return IFormControl
	 */
	function setDefaultValue($value);

	/**
	 * gets the value, either imported or default (might be null)
	 * @return mixed
	 */
	function getValue();

	/**
	 * determines whether errors occurred during value import
	 * @return boolean
	 */
	function hasError();

	/**
	 * @return FormControlError
	 */
	function getError();

	/**
	 * @abstract
	 * @param FormControlError $error
	 * @return IFormControl
	 */
	function setError(FormControlError $error);

	/**
	 * @return string
	 */
	function getErrorMessage();

	/**
	 * Resets the import state and errors
	 * @return IFormControl
	 */
	function reset();

	/**
	 * gets the HTML representation of a form
	 * @param array $htmlAttributes
	 * @return string
	 */
	function toHtml(array $htmlAttributes = array());
}

