<?php
/**
 * Created at: 20/06/16 19:31
 * Generated by migration.php
 */

namespace Models\Generated;

use SmartModel;


/* REQUIRED FIELDS FIRST, NULLABLE FIELDS AFTER. ALL FIELDS ARE DOWN BELOW.

contactID
contactName

phoneNumber
faxNumber
email
physicalAddress
*/


/**
 * Model Contact.
 * @package Models
 */
class ModelContact extends SmartModel
{
    /**
     * @var int $contactID
     */
    public $contactID;

    /**
     * @var string $contactName
     */
    public $contactName;

    /**
     * @var string|null $phoneNumber
     */
    public $phoneNumber;

    /**
     * @var string|null $faxNumber
     */
    public $faxNumber;

    /**
     * @var string|null $email
     */
    public $email;

    /**
     * @var string|null $physicalAddress
     */
    public $physicalAddress;


    /**
     * ModelContact constructor.
     */
    public function __construct()
    {
        parent::__construct($this, "Contacts");
    }

}