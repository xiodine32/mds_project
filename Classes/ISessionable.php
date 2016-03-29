<?php

/**
 * Created at: 29/03/16 16:14
 */
interface ISessionable
{
    /**
     * Saves the model to session.
     * @param IModel $item
     */
    static function toSession($item);

    /**
     * Reads the model from session.
     * @return false|IModel
     */
    static function fromSession();
}