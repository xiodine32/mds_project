<?php
/**
 * Created at: 01/04/16 13:00
 * Generated by migration.php
 */

namespace Models\Generated;

use SmartModel;

/**
 * Model Education.
 * @package Models
 */
class ModelEducation extends SmartModel
{
    /**
     * @var int $educationID 
     */
    public $educationID;

    /**
     * @var string $title 
     */
    public $title;

    /**
     * @var string $startDate 
     */
    public $startDate;

    /**
     * @var string $endDate 
     */
    public $endDate;

    /**
     * @var string $degree 
     */
    public $degree;

    /**
     * @var int $employeeID 
     */
    public $employeeID;


    /**
     * ModelEducation constructor.
     */
    public function __construct()
    {
        parent::__construct($this, "Educations");
    }

}