<?php

/**
 * Created at: 29/03/16 16:14
 */

/**
 * Interface ISessionable
 */
interface ISessionable
{
    /**
     * Saves the model to session.
     * @param ISessionable $item
     * @param Request $request
     */
    static function toSession($item, $request);

    /**
     * Reads the model from session.
     * @param Request $request
     * @return false|ISessionable
     */
    static function fromSession($request);

    /**
     * Removes the item from session.
     * @param Request $request
     */
    static function unsetSession($request);
}