<?php

/**
 * Created at: 29/03/16 12:34
 */

abstract class Controller
{
    protected $viewbag;
    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->viewbag = [];
    }

    public function run()
    {
        // curate
        $_GET = $this->curate($_GET);
        $_POST = $this->curate($_POST);
        $_FILES = $this->curate($_FILES);
        $view = $this->call($_GET, $_POST, $_FILES);

        $view->setImplicitViewName(get_called_class());

        echo "<pre>";
        var_dump($view);
        echo "</pre>";

        $view->apply($this->viewbag);
//        require $name;
    }

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

    /**
     * @param array $get
     * @param array $post
     * @param array $files
     * @return \View
     */
    public abstract function call($get, $post, $files);


}