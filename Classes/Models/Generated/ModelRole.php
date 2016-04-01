<?php
/**
 * Created at: 01/04/16 14:03
 * Generated by migration.php
 */

namespace Models\Generated;

use SmartModel;

/**
 * Model Role.
 * @package Models
 */
class ModelRole extends SmartModel
{
    /**
     * @var int $roleID
     */
    public $roleID;

    /**
     * @var string $name
     */
    public $name;

    /**
     * @var string|null $jobDescription
     */
    public $jobDescription;

    /**
     * @var double $averageSalary
     */
    public $averageSalary;


    /**
     * ModelRole constructor.
     */
    public function __construct()
    {
        parent::__construct($this, "Roles");
    }

}