<?php
/**
 * Created at: 19/06/16 01:43
 * Generated by migration.php
 */

namespace Models\Generated;

use SmartModel;


/* REQUIRED FIELDS FIRST, NULLABLE FIELDS AFTER. ALL FIELDS ARE DOWN BELOW.

educationID
title
startDate
endDate
degree
employeeID


*/


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