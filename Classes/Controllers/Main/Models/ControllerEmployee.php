<?php
/**
 * Created at: 21/06/2016 00:28
 * Generated by ControllerIndex.php
 */

namespace Controllers\Main\Models;

use Controllers\Main\ControllerCRUD;
use Models\Generated\ModelEmployee;

class ControllerEmployee extends ControllerCRUD
{
    public function __construct()
    {
        // constructor
        parent::__construct($this, new ModelEmployee());

        // not null
        $this->addItem("employeeID", false, "int", 11);
        $this->addItem("account", false, "varchar", 50);
        $this->addItem("password", false, "varchar", 64);
        $this->addItem("firstName", false, "varchar", 50);
        $this->addItem("lastName", false, "varchar", 50);
        $this->addItem("title", false, "varchar", 50);
        $this->addItem("cnp", false, "varchar", 13);
        $this->addItem("salary", false, "double", null);
        $this->addItem("priorSalary", false, "double", null);
        $this->addItem("hireDate", false, "date", null);
        $this->addItem("administrator", false, "int", 1);

        // nullable
        $this->addItem("middleInitial", true, "char", 1);
        $this->addItem("terminationDate", true, "date", null);
        $this->addItem("projectID", true, "int", 11);
        $this->addItem("managerID", true, "int", 11);
        $this->addItem("roleID", true, "int", 11);
        $this->addItem("departmentID", true, "int", 11);
    }
}