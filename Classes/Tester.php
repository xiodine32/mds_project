<?php

/**
 * Created by PhpStorm.
 * User: Xiodine
 * Date: 14/06/2016
 * Time: 11:45
 */
class Tester
{
    public $failed;

    private $theThis;

    public function loadClass($className)
    {
        $this->theThis = new $className();
        return true;
    }

    /**
     * @param $fieldName string
     * @param $value string
     * @return boolean
     */
    public function expectField($fieldName, $value)
    {
        if ($value == "null")
            $value = null;
        $b = $this->getField($fieldName) == $value;
        if (!$b)
            $this->failed = true;
        return $b;
    }

    public function getField($fieldName)
    {
        return $this->theThis->$fieldName;
    }

    /**
     * @param $line string
     * @return boolean
     */
    public function evaluateExpression($line)
    {
        $str = "\$result = " . $line . ";return \$result;";
        $str = str_replace('$this', '$this->theThis', $str);
        $result = eval($str);
        if (!$result)
            $this->failed = true;
        return $result;
    }

    public function runMethod($line)
    {
        $str = '$this->theThis->' . $line . ";";
        eval($str);
    }
}