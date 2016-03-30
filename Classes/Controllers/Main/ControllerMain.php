<?php
/**
 * Created at: 29/03/16 13:41
 */

namespace Controllers\Main;


use Models\ModelEmployee;

abstract class ControllerMain extends \Controller
{

    /**
     * @var ModelEmployee
     */
    protected $employee;

    /**
     * @param array $get
     * @param array $post
     * @param array $files
     * @return \View
     */
    public function call($get, $post, $files)
    {
        $this->employee = ModelEmployee::fromSession();

        if ($this->employee === false) {
            return new \Redirect("login");
        }

        $this->viewbag['title'] = 'Main Page';
        $this->viewbag['employee'] = $this->employee;

        return $this->callLogged($get, $post, $files);
    }

    protected abstract function callLogged($get, $post, $files);
}