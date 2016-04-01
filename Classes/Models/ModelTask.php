<?php
/**
 * Created at: 01/04/16 12:09
 * Generated by migration.php
 */

namespace Models;

use SmartModel;

/**
 * Model Task.
 * @package Models
 */
class ModelTask extends SmartModel
{
    public $taskID;
    public $sprintID;
    public $employeeID;
    public $roleID;
    public $startDate;
    public $endDate;
    public $taskDescription;
    public $difficulty;
    public $estimation;

    /**
     * ModelTask constructor.
     */
    public function __construct()
    {
        parent::__construct($this, "Tasks");
    }

}