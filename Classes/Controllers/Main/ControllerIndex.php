<?php
/**
 * Created at: 29/03/16 13:41
 */

namespace Controllers\Main;


/**
 * Index Controller Main
 * @package Controllers\Main
 */
class ControllerIndex extends ControllerMain
{
    /**
     * Displays simple information to the Employee.
     * @param array $get Curated GET.
     * @param array $post Curated POST.
     * @param array $files Curated FILES.
     * @return \View The View to be displayed.
     */
    protected function mainCall($get, $post, $files)
    {
        $this->viewbag['title'] = 'Main Page';

        return new \View();
    }
}