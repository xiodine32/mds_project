<?php

namespace Models;

use IModel;
use ISessionable;

/**
 * Created at: 29/03/16 15:44
 */
class ModelEmployee extends DefaultDUI implements \IModel, \ISessionable
{
    private $employeeID;
    private $roleID;
    private $account;
    private $password;
    private $managerID;
    private $departmentID;
    private $firstName;
    private $middleInitial;
    private $lastName;
    private $title;
    private $cnp;
    private $salary;
    private $priorSalary;
    private $hireDate;
    private $terminationDate;
    private $administrator;

    /**
     * ModelEmployee constructor.
     */
    public function __construct()
    {
        parent::__construct($this);
    }

    /**
     * Returns the table name.
     * @return string
     */
    static function tableName()
    {
        return "Employees";
    }

    /**
     * Returns the primary key name.
     * @return string
     */
    static function tablePrimaryKey()
    {
        return "employeeID";
    }

    /**
     * Returns the model names (without primary key).
     * @return string[]
     */
    static function tableNames()
    {
        return ["roleID",
            "account",
            "password",
            "managerID",
            "departmentID",
            "firstName",
            "middleInitial",
            "lastName",
            "title",
            "cnp",
            "salary",
            "priorSalary",
            "hireDate",
            "terminationDate",
            "administrator"];
    }

    /**
     * @param array $table Database table.
     * @return IModel
     */
    static function fromDatabase($table)
    {
        $gv = new ModelEmployee();
        $gv->employeeID = $table['employeeID'];
        $gv->roleID = $table['roleID'];
        $gv->account = $table['account'];
        $gv->password = $table['password'];
        $gv->managerID = $table['managerID'];
        $gv->departmentID = $table['departmentID'];
        $gv->firstName = $table['firstName'];
        $gv->middleInitial = $table['middleInitial'];
        $gv->lastName = $table['lastName'];
        $gv->title = $table['title'];
        $gv->cnp = $table['cnp'];
        $gv->salary = $table['salary'];
        $gv->priorSalary = $table['priorSalary'];
        $gv->hireDate = $table['hireDate'];
        $gv->terminationDate = $table['terminationDate'];
        $gv->administrator = $table['administrator'];
        return $gv;
    }

    /**
     * Selects one model from the database.
     * @param string [$where] Where Query.
     * @param array [$prepared] Prepared Values.
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
     * Reads the model from session.
     * @return false|IModel
     */
    static function fromSession()
    {
        if (!isset($_SESSION['employee']))
            return false;
        return unserialize($_SESSION['employee']);
    }

    /**
     * Removes the item from session.
     * @param $item ISessionable
     */
    static function unsetSession($item)
    {
        unset($_SESSION['employee']);
    }

    public function tryLogin($password)
    {
        if ($this->password === $password) {
            $this->password = password_hash($this->password, PASSWORD_BCRYPT);
            self::databaseUpdate();
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
     * @param IModel $item
     */
    static function toSession($item)
    {
        $_SESSION['employee'] = serialize($item);
    }

    /**
     * @return mixed
     */
    public function getEmployeeID()
    {
        return $this->employeeID;
    }

    /**
     * @param mixed $employeeID
     */
    public function setEmployeeID($employeeID)
    {
        $this->employeeID = $employeeID;
    }

    /**
     * @return mixed
     */
    public function getRoleID()
    {
        return $this->roleID;
    }

    /**
     * @param mixed $roleID
     */
    public function setRoleID($roleID)
    {
        $this->roleID = $roleID;
    }

    /**
     * @return mixed
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @param mixed $account
     */
    public function setAccount($account)
    {
        $this->account = $account;
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
     * @return mixed
     */
    public function getManagerID()
    {
        return $this->managerID;
    }

    /**
     * @param mixed $managerID
     */
    public function setManagerID($managerID)
    {
        $this->managerID = $managerID;
    }

    /**
     * @return mixed
     */
    public function getDepartmentID()
    {
        return $this->departmentID;
    }

    /**
     * @param mixed $departmentID
     */
    public function setDepartmentID($departmentID)
    {
        $this->departmentID = $departmentID;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getMiddleInitial()
    {
        return $this->middleInitial;
    }

    /**
     * @param mixed $middleInitial
     */
    public function setMiddleInitial($middleInitial)
    {
        $this->middleInitial = $middleInitial;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getCnp()
    {
        return $this->cnp;
    }

    /**
     * @param mixed $cnp
     */
    public function setCnp($cnp)
    {
        $this->cnp = $cnp;
    }

    /**
     * @return mixed
     */
    public function getSalary()
    {
        return $this->salary;
    }

    /**
     * @param mixed $salary
     */
    public function setSalary($salary)
    {
        $this->salary = $salary;
    }

    /**
     * @return mixed
     */
    public function getPriorSalary()
    {
        return $this->priorSalary;
    }

    /**
     * @param mixed $priorSalary
     */
    public function setPriorSalary($priorSalary)
    {
        $this->priorSalary = $priorSalary;
    }

    /**
     * @return mixed
     */
    public function getHireDate()
    {
        return $this->hireDate;
    }

    /**
     * @param mixed $hireDate
     */
    public function setHireDate($hireDate)
    {
        $this->hireDate = $hireDate;
    }

    /**
     * @return mixed
     */
    public function getTerminationDate()
    {
        return $this->terminationDate;
    }

    /**
     * @param mixed $terminationDate
     */
    public function setTerminationDate($terminationDate)
    {
        $this->terminationDate = $terminationDate;
    }

    /**
     * @return mixed
     */
    public function getAdministrator()
    {
        return $this->administrator;
    }

    /**
     * @param mixed $administrator
     */
    public function setAdministrator($administrator)
    {
        $this->administrator = $administrator;
    }
}