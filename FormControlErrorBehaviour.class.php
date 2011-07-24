<?php


/**
 * Defines the behaviour of control on import error (usually, FormControlError::WRONG for StringFormControl)
 * @ingroup Form
 */
final class FormControlErrorBehaviour extends Enumeration
{
	const LEAVE_AS_IS = 0;
	const SET_EMPTY = 1;
	const USE_DEFAULT = 2;

    static function leaveAsIs()
    {
        return new self (self::LEAVE_AS_IS);
    }

    static function setEmpty()
    {
        return new self (self::SET_EMPTY);
    }

    static function useDefault()
    {
        return new self (self::USE_DEFAULT);
    }
}

