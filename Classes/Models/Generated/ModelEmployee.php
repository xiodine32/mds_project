<?php
/**
 * Created at: 01/04/16 16:25
 * Generated by migration.php
 */

namespace Models\Generated;

use SmartModel;

/**
 * Model Employee.
 * @package Models
 */
class ModelEmployee extends SmartModel
{
    /**
     * @var int $employeeID
     */
    public $employeeID;

    /**
     * @var int|null $roleID
     */
    public $roleID;

    /**
     * @var string $account
     */
    public $account;

    /**
     * @var string $password
     */
    public $password;

    /**
     * @var int|null $managerID
     */
    public $managerID;

    /**
     * @var int|null $departmentID
     */
    public $departmentID;

    /**
     * @var string $firstName
     */
    public $firstName;

    /**
     * @var string|null $middleInitial
     */
    public $middleInitial;

    /**
     * @var string $lastName
     */
    public $lastName;

    /**
     * @var string $title
     */
    public $title;

    /**
     * @var string $cnp
     */
    public $cnp;

    /**
     * @var double $salary
     */
    public $salary;

    /**
     * @var double $priorSalary
     */
    public $priorSalary;

    /**
     * @var string $hireDate
     */
    public $hireDate;

    /**
     * @var string|null $terminationDate
     */
    public $terminationDate;

    /**
     * @var int $administrator
     */
    public $administrator;


    /**
     * ModelEmployee constructor.
     */
    public function __construct()
    {
        parent::__construct($this, "Employees");
    }

}