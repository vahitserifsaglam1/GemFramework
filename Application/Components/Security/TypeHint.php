<?php
namespace Gem\Components\Security;
/**
 * Bu sınıf string,integer gibi tiplere zorunluluk getirmek için yapılmıştır
 * Class TypeHint
 * @package Gem\Components\Security
 */

class TypeHint
{
    public static $types = [

        'integer' => 'is_integer',
        'string' => 'is_string',
        'float' => 'is_float',
        'resource' => 'is_resource',
        'double' => 'is_double'

    ];
    /**
     * Error Handleri Atar
     * @access public
     */
    public static function boot()
    {

        set_error_handler('Gem\Components\Security\TypeHint::hint');

    }

    public static function hint($errLevel, $errMessage)
    {


        if ($errLevel === E_RECOVERABLE_ERROR) {

            if ($explode = explode(' ', $errMessage)) {

                if (
                    $explode[0] === 'Argument' &&
                    $explode[2] === 'passed' &&
                    $explode[3] === 'to' &&
                    $explode[5] === 'must' &&
                    $explode[20] === 'defined'
                ) {
                    $arg = $explode[1] - 1;
                    $mustType = $explode[10];
                    $back = debug_backtrace()[1];
                    $explode = explode('\\', $mustType);
                    $end = end($explode);
                    $getLastType = rtrim($end, ',');
                    $args = $back['args'];
                    $arg = $args[$arg];
                    if (gettype($arg) != $getLastType) {
                        if (call_user_func(static::$types[$getLastType], $arg)) {
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        return true;
                    }
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }
}
