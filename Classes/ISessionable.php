<?php

/**
 * Created at: 29/03/16 16:14
 */
interface ISessionable
{
    /**
     * Saves the model to session.
     * @param ISessionable $item
     */
    static function toSession($item);

    /**
     * Reads the model from session.
     * @return false|ISessionable
     */
    static function fromSession();

    /**
     * Removes the item from session.
     * @param $item ISessionable
     */
    static function unsetSession($item);
}