<?php
/**
 * Created at: 29/03/16 13:41
 */

namespace Controllers\Main;


class ControllerIndex extends \Controller
{

    /**
     * @param array $get
     * @param array $post
     * @param array $files
     * @return \View
     */
    public function call($get, $post, $files)
    {
        return new \View("../405");
    }
}