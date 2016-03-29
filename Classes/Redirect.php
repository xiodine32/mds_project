<?php

/**
 * Created at: 29/03/16 12:34
 */
class Redirect extends View
{
    private $name;

    /**
     * View constructor.
     * @param null|string $name
     * @param boolean $isPartial
     */
    public function __construct($name)
    {
        parent::__construct($name, false);
        $this->name = $name;
    }

    public function apply($viewbag)
    {
        $this->name = ltrim($this->name, "/");
        header("Location: " . $this->applyRoot() . $this->name);
    }


}