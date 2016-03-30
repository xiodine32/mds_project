<?php
/**
 * Created at: 29/03/16 13:41
 */

namespace Controllers\Main;


class ControllerIndex extends ControllerMain
{
    protected function callLogged($get, $post, $files)
    {
        if ($this->isEqualGetKey('logout', 'true'))
            return new \Redirect("/main/logout");
        $this->viewbag['title'] = 'Main Page';
        return new \View();
    }
}