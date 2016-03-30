<?php
/**
 * Created at: 29/03/16 13:41
 */

namespace Controllers\Main;


use Models\ModelEmployee;

class ControllerLogout extends ControllerMain
{
    protected function callLogged($get, $post, $files)
    {
        ModelEmployee::unsetSession($this->employee);
        return new \Redirect("/");
    }
}