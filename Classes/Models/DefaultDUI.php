<?php
/**
 * Created at: 29/03/16 16:22
 */

namespace Models;


abstract class DefaultDUI
{
    private $theThis;

    /**
     * DefaultDUI constructor.
     * @param \IModel $theThis
     */
    public function __construct($theThis)
    {
        $this->theThis = $theThis;
    }


    /**
     * Inserts the model into the database.
     * @return boolean
     */
    function databaseInsert()
    {
        return \Helper::databaseInsertDefault($this->theThis);
    }

    /**
     * Updates the model in the database.
     * @return boolean
     */
    function databaseUpdate()
    {
        return \Helper::databaseUpdateDefault($this->theThis);
    }

    /**
     * Deletes the model from the database.
     * @return boolean
     */
    function databaseDelete()
    {
        return \Helper::databaseDeleteDefault($this->theThis);
    }
}