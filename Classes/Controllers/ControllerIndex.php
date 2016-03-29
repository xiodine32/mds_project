<?php
/**
 * Created at: 29/03/16 12:34
 */

namespace Controllers;

use Controller;

class ControllerIndex extends Controller {

    public function call($get, $post, $files)
    {
        $this->viewbag["title"] = "Index";
        return new \View();
    }
};