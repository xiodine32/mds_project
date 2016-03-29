<?php

/**
 * Created at: 29/03/16 12:34
 */
class View
{
    private $name;
    private $partial;
    private $path;
    private $callArray = [];
    private $callIndex = -1;
    private $viewbag;

    /**
     * View constructor.
     * @param null|string $name
     * @param boolean $isPartial
     */
    public function __construct($name = null, $isPartial = false)
    {
        $this->name = $name;
        $this->partial = $isPartial;
    }

    /**
     * @return null|string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return boolean
     */
    public function isPartial()
    {
        return $this->partial;
    }

    /**
     * @param string $className
     * @return string
     */
    public function setImplicitViewName($className)
    {
        $skipName = false;
        if ($this->name !== null)
            $skipName = true;

        $name = substr($className, 11);
        $spaced = explode("\\", trim($name, "\\"));
        $n = count($spaced);
        $spaced[$n - 1] = substr($spaced[$n - 1], 10);
        foreach ($spaced as $key => $value) {
            $spaced[$key] = strtolower($value);
        }
        if ($skipName)
            $spaced[$n - 1] = $this->name;
        $this->path = __DIR__ . "/Views/" . implode("/", array_slice($spaced, 0, -1));
        $this->name = __DIR__ . "/Views/" . implode("/", $spaced) . ".php";
    }

    public function apply($viewbag)
    {
        $this->viewbag = $viewbag;
        $this->viewbag['root'] = $this->applyRoot();

        if (!$this->partial) {
            $this->callArray = $this->layout();
            $this->callArray[] = $this->name;
            $this->callIndex = -1;
            $this->continueRun();
        } else {
            if (is_file($this->name)) {
                /** @noinspection PhpIncludeInspection */
                require $this->name;
            }
        }

    }

    /**
     * @return string
     */
    private function applyRoot()
    {
        $depth = 0;
        str_replace("/", "", $GLOBALS['PAGE_STR'], $depth);
        $root = './';
        $root .= str_repeat("../", $depth);
        return $root;
    }

    private function layout()
    {
        $arr = [];
        $path = rtrim($this->path, "/") . "/";

        do {
            if (substr($path, -8) === "Classes/")
                break;
            $arr[] = $path;
            $path = substr($path, 0, strrpos(substr($path, 0, -1), "/") + 1);
        } while (true);

        return $arr;
    }

    private function continueRun()
    {
        $this->callIndex++;
        $item = $this->callArray[$this->callIndex];
        if ($this->callIndex != count($this->callArray) - 1)
            $item .= "_layout.php";
//        echo "<pre>";var_dump($item);echo "</pre>";
        if (is_file($item)) {
            /** @noinspection PhpUnusedLocalVariableInspection */
            $viewbag = $this->viewbag;
            /** @noinspection PhpIncludeInspection */
            require $item;
        }
        $this->callIndex--;
    }
}