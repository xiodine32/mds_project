<?php

namespace Models;

use IModel;

/**
 * Created at: 29/03/16 15:44
 */
class ModelUser extends DefaultDUI implements \IModel, \ISessionable
{
    private $id;
    private $username;
    private $password;
    private $loggedIn;

    public function __construct($username)
    {
        parent::__construct($this);
        $this->id = null;
        $this->username = $username;
        $this->loggedIn = false;
    }

    /**
     * Reads the model from session.
     * @return false|ModelUser
     */
    static function fromSession()
    {
        if (!isset($_SESSION['user_username']) || !isset($_SESSION['user_id']) || !isset($_SESSION['user_loggedIn']))
            return false;
        $item = new ModelUser($_SESSION['user_username']);
        $item->id = $_SESSION['user_id'];
        $item->loggedIn = $_SESSION['user_loggedIn'];
        return $item;
    }

    /**
     * Returns the primary key name.
     * @return string
     */
    static function tablePrimaryKey()
    {
        return "id";
    }

    /**
     * Returns the model names (without primary key).
     * @return string[]
     */
    static function tableNames()
    {
        return ["username", "password"];
    }

    /**
     * Returns the table name.
     * @return string
     */
    static function tableName()
    {
        return "users";
    }

    /**
     * Selects one model from the database.
     * @param string $where
     * @param array $prepared
     * @return null|IModel
     */
    static function databaseSelect($where = '', $prepared = [])
    {
        return \Helper::databaseSelectDefault(__CLASS__, $where, $prepared, \Database::FETCH_ONE);
    }

    /**
     * Selects all models from the database.
     * @param string [$where] Where Query.
     * @param array [$prepared] Prepared Values.
     * @return IModel[]
     */
    static function databaseSelectAll($where = '', $prepared = [])
    {
        return \Helper::databaseSelectDefault(__CLASS__, $where, $prepared, \Database::FETCH_ALL);
    }

    /**
     * @param array $table Database table.
     * @return IModel
     */
    static function fromDatabase($table)
    {
        $gv = new ModelUser($table['username']);
        $gv->id = $table['id'];
        $gv->password = $table['password'];
        $gv->loggedIn = false;
        return $gv;
    }

    public function tryLogin($password)
    {
        if (!password_verify($password, $this->password)) {
            return false;
        }
        $this->loggedIn = true;
        self::toSession($this);
        return true;
    }

    /**
     * Saves the model to session.
     * @param ModelUser $item
     */
    static function toSession($item)
    {
        $_SESSION['user_id'] = $item->id;
        $_SESSION['user_username'] = $item->username;
        $_SESSION['user_loggedIn'] = $item->loggedIn;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * @return null|int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return boolean
     */
    public function isLoggedIn()
    {
        return $this->loggedIn;
    }

}