<?php
/**
 * Created by PhpStorm.
 * User: radu
 * Date: 4/10/16
 * Time: 4:29 PM
 */

namespace Models;


use Request;
use Sessionable;

class ModelSprint extends Generated\ModelSprint implements \Sessionable
{

    /**
     * Saves the model to session.
     * @param Sessionable $item
     * @param Request $request
     */
    static function toSession($item, $request)
    {
        // TODO: Implement toSession() method.
    }

    /**
     * Reads the model from session.
     * @param Request $request
     * @return false|Sessionable
     */
    static function fromSession($request)
    {
        // TODO: Implement fromSession() method.
    }

    /**
     * Removes the item from session.
     * @param Request $request
     */
    static function unsetSession($request)
    {
        // TODO: Implement unsetSession() method.
    }
}