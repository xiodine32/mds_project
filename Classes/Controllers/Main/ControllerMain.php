<?php
/**
 * Created at: 29/03/16 13:41
 */

namespace Controllers\Main;


use Models\ModelUser;

abstract class ControllerMain extends \Controller
{

    /**
     * @param array $get
     * @param array $post
     * @param array $files
     * @return \View
     */
    public function call($get, $post, $files)
    {
        $user = ModelUser::fromSession();
        if ($user === false) {
            return new \Redirect("login");
        }
        $this->viewbag['title'] = 'Main Page';
        return $this->callLogged($get, $post, $files);
    }

    protected abstract function callLogged($get, $post, $files);
}