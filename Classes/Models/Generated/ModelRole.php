<?php
/**
 * Created at: 20/06/16 19:31
 * Generated by migration.php
 */

namespace Models\Generated;

use SmartModel;


/* REQUIRED FIELDS FIRST, NULLABLE FIELDS AFTER. ALL FIELDS ARE DOWN BELOW.

roleID
name
averageSalary

jobDescription
*/


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