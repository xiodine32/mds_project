<?php
/**
 * Created at: 29/03/16 13:41
 */

namespace Controllers\Main;


use Models\ModelEmployee;

/**
 * Logout Controller Main
 * @package Controllers\Main
 */
class ControllerLogout extends ControllerMain
{
    /**
     * Logs out the employee and redirects to root page.
     * @param array $get Curated GET.
     * @param array $post Curated POST.
     * @param array $files Curated FILES.
     * @return \View The View to be displayed.
     */
    protected function mainCall($get, $post, $files)
    {
        ModelEmployee::unsetSession($this->employee);
        return new \Redirect("/");
    }
}