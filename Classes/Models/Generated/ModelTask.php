<?php
/**
 * Created at: 05/04/16 16:29
 * Generated by migration.php
 */

namespace Models\Generated;

use SmartModel;

/**
 * Model Task.
 * @package Models
 */
class ModelTask extends SmartModel
{
    /**
     * @var int $taskID
     */
    public $taskID;

    /**
     * @var int|null $sprintID
     */
    public $sprintID;

    /**
     * @var int|null $employeeID
     */
    public $employeeID;

    /**
     * @var int|null $roleID
     */
    public $roleID;

    /**
     * @var string|null $startDate
     */
    public $startDate;

    /**
     * @var string|null $endDate
     */
    public $endDate;

    /**
     * @var string $taskDescription
     */
    public $taskDescription;

    /**
     * @var int $difficulty
     */
    public $difficulty;

    /**
     * @var int|null $estimation
     */
    public $estimation;


    /**
     * ModelTask constructor.
     */
    public function __construct()
    {
        parent::__construct($this, "Tasks");
    }

}