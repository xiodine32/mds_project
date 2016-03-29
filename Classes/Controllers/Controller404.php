<?php
/**
 * Created at: 29/03/16 13:33
 */

namespace Controllers;


class Controller404 extends \Controller
{

    public function call($get, $post, $files)
    {
        $this->viewbag['title'] = '404';
        return new \View();
    }
}