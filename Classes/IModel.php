<?php

/**
 * Created at: 29/03/16 12:34
 */
interface IModel
{

    /**
     * Returns the table name.
     * @return string
     */
    static function tableName();

    /**
     * Returns the primary key name.
     * @return string
     */
    static function tablePrimaryKey();

    /**
     * Returns the model names (without primary key).
     * @return string[]
     */
    static function tableNames();

    /**
     * @param array $table Database table.
     * @return IModel
     */
    static function fromDatabase($table);


    /**
     * Selects one model from the database.
     * @param string [$where] Where Query.
     * @param array [$prepared] Prepared Values.
     * @return null|IModel
     */
    static function databaseSelect($where = '', $prepared = []);

    /**
     * Selects all models from the database.
     * @param string [$where] Where Query.
     * @param array [$prepared] Prepared Values.
     * @return IModel[]
     */
    static function databaseSelectAll($where = '', $prepared = []);

    /**
     * Inserts the model into the database.
     */
    function databaseInsert();

    /**
     * Updates the model in the database.
     */
    function databaseUpdate();

    /**
     * Deletes the model from the database.
     */
    function databaseDelete();

}