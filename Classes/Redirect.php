<?php

/**
 * Created at: 29/03/16 12:34
 */
class Redirect extends View
{
    private $name;

    /**
     * View constructor.
     * @param null|string $name Name of file (relative to current controller)
     */
    public function __construct($name)
    {
        parent::__construct($name, true);
        $this->name = $name;
    }

    /**
     * Apply view into existance.
     * @param $viewbag array Viewbag
     */
    public function apply($viewbag)
    {
        $this->name = ltrim($this->name, "/");
        header("Location: " . $this->applyRoot() . $this->name);
    }


}