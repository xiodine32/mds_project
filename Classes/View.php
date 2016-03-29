<?php

/**
 * Created at: 29/03/16 12:34
 */
class View
{
    private $name;
    private $partial;
    private $path;

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
        $this->layout("header", $viewbag, true);
        if (is_file($this->name)) {
            /** @noinspection PhpIncludeInspection */
            require $this->name;
        }
        $this->layout("footer", $viewbag, false);

    }

    /**
     * @param string $layoutName
     * @param array $viewbag
     * @param bool $inverted
     * @param null $path
     */
    private function layout($layoutName, $viewbag, $inverted = true, $path = null)
    {
        if ($this->partial)
            return;
        if (!isset($viewbag)) die();

        if ($path == null)
            $path = rtrim($this->path, "/") . "/";

        if (substr($path, -8) === "Classes/")
            return;
        if ($inverted)
            $this->layout($layoutName, $viewbag, $inverted, substr($path, 0, strrpos(substr($path, 0, -1), "/") + 1));

        if (is_dir($path . "layout")) {
            /** @noinspection PhpIncludeInspection */
            require $path . "layout/{$layoutName}.php";
        }

        if (!$inverted)
            $this->layout($layoutName, $viewbag, $inverted, substr($path, 0, strrpos(substr($path, 0, -1), "/") + 1));
    }
}