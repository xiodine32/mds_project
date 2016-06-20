<?php
/**
 * Created at: 21/06/2016 00:28
 * Generated by ControllerIndex.php
 */

namespace Controllers\Main\Models;

use Controllers\Main\ControllerCRUD;
use Models\Generated\ModelDepartment;

class ControllerDepartment extends ControllerCRUD
{
    public function __construct()
    {
        // constructor
        parent::__construct($this, new ModelDepartment());

        // not null
        $this->addItem("departmentID", false, "int", 11);
        $this->addItem("title", false, "varchar", 50);
        $this->addItem("maxSize", false, "int", 11);
        $this->addItem("startDate", false, "date", null);
        $this->addItem("monthlyExpenses", false, "double", null);

        // nullable
        $this->addItem("deptDescription", true, "text", null);
    }
}