<?php

/**
 * Created at: 29/03/16 15:34
 */
class Helper
{
    /**
     * @param array $array
     * @param mixed $key
     * @param mixed $item
     * @return bool
     */
    public static function existsAndEquals($array, $key, $item)
    {
        return isset($array) && isset($array[$key]) && $array[$key] === $item;
    }
}