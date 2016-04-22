<?php

/**
 * Created at: 22/04/16 16:45
 */
class ViewJSON extends View
{
    private $jsonText;


    /**
     * ViewJSON constructor.
     * @param string $jsonText
     * @param boolean|null $isPartial
     */
    public function __construct($jsonText, $isPartial = null)
    {
        $this->jsonText = $jsonText;
        parent::__construct("", $isPartial);
        header('Content-Type: application/json');
    }

    protected function includeItem($item)
    {
        if (substr($item, -5) === "/.php") {
            echo $this->jsonText;
            return;
        }

        parent::includeItem($item);
    }

}