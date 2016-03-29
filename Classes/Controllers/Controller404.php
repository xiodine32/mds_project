<?php
/**
 * Created at: 29/03/16 13:33
 */

namespace Controllers;


class Controller404 extends \Controller
{

    public function call($get, $post, $files)
    {
        return new \View();
    }
}