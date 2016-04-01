<?php

/**
 * Created at: 01/04/16 16:12
 */
class EmptyModel extends SmartModel
{

    /**
     * EmptyModel constructor.
     * @param string $tableName
     */
    public function __construct($tableName)
    {
        parent::__construct($this, $tableName);
    }
}