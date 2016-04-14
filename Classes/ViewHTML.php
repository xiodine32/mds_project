<?php

/**
 * Created at: 06/04/16 13:53
 */
class HTMLView extends View
{
    private $htmlText;


    /**
     * HTMLView constructor.
     * @param string $htmlText
     * @param boolean|null $isPartial
     */
    public function __construct($htmlText, $isPartial = null)
    {
        $this->htmlText = $htmlText;
        parent::__construct("", $isPartial);
    }

    protected function includeItem($item)
    {
        if (substr($item, -5) === "/.php") {
            echo $this->htmlText;
            return;
        }

        parent::includeItem($item);
    }


}