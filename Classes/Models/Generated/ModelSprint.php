<?php
/**
 * Created at: 01/04/16 16:25
 * Generated by migration.php
 */

namespace Models\Generated;

use SmartModel;

/**
 * Model Sprint.
 * @package Models
 */
class ModelSprint extends SmartModel
{
    /**
     * @var int $sprintID
     */
    public $sprintID;

    /**
     * @var int $projectID
     */
    public $projectID;

    /**
     * @var string $startDate
     */
    public $startDate;

    /**
     * @var string $endDate
     */
    public $endDate;


    /**
     * ModelSprint constructor.
     */
    public function __construct()
    {
        parent::__construct($this, "Sprints");
    }

}