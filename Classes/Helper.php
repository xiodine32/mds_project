<?php

/**
 * Created at: 29/03/16 15:34
 */

/**
 * Class Helper
 */
class Helper
{
    /**
     * Returns true if key exists and is equal to the value given.
     * @param array $array Array to search key in.
     * @param mixed $key Key to search value for.
     * @param mixed $value Value to be equal to (strict casting)
     * @return bool <b>TRUE</b> if key exists in array and key is equal to value.
     */
    public static function existsAndEquals($array, $key, $value)
    {
        return isset($array) && isset($array[$key]) && $array[$key] === $value;
    }
}