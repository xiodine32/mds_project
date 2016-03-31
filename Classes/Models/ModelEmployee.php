<?php
/** @noinspection PhpUnusedPrivateFieldInspection */

namespace Models;

use SmartModel;

/**
 * Created at: 29/03/16 15:44
 */
class ModelEmployee extends SmartModel implements \ISessionable
{
    public $employeeID;
    public $roleID;
    public $account;
    public $password;
    public $managerID;
    public $departmentID;
    public $firstName;
    public $middleInitial;
    public $lastName;
    public $title;
    public $cnp;
    public $salary;
    public $priorSalary;
    public $hireDate;
    public $terminationDate;
    public $administrator;

    /**
     * ModelEmployee constructor.
     */
    public function __construct()
    {
        parent::__construct($this, "Employees");
    }

    /**
     * Reads the model from session.
     * @return false|ModelEmployee
     */
    static function fromSession()
    {
        if (!isset($_SESSION['employee']))
            return false;
        return unserialize($_SESSION['employee']);
    }

    /**
     * Removes the item from session.
     * @param $item \ISessionable
     */
    static function unsetSession($item)
    {
        unset($_SESSION['employee']);
    }

    public function tryLogin($password)
    {
        if ($this->password === $password) {
            $this->password = password_hash($this->password, PASSWORD_BCRYPT);
            self::update();
            self::toSession($this);
            return true;
        }
        if (!password_verify($password, $this->password)) {
            return false;
        }
        self::toSession($this);
        return true;
    }

    /**
     * Saves the model to session.
     * @param \ISessionable $item
     */
    static function toSession($item)
    {
        $_SESSION['employee'] = serialize($item);
    }


    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }
}