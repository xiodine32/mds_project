<?php

/**
 * Created at: 29/03/16 12:34
 */

abstract class Controller
{
    /**
     * @param $item mixed
     * @return mixed
     */
    private function curate($item)
    {
        if (is_array($item)) {
            foreach ($item as $key => $value) {
                $item[$key] = $this->curate($value);
            }
            return $item;
        }
        if (!is_callable($item))
            return htmlspecialchars($item);
        return $item;
    }

    public function run()
    {
        // curate
        $_GET = $this->curate($_GET);
        $_POST = $this->curate($_POST);
        $_FILES = $this->curate($_FILES);
        $this->call($_GET, $_POST, $_FILES);
    }
    public abstract function call($get, $post, $files);
}