<?php
/**
 * Created at: 29/03/16 12:34
 */

namespace Controllers;

use Controller;

/**
 * Index Controller
 * @package Controllers
 */
class ControllerIndex extends Controller {

    /**
     * Redirects user to login page as we don't have a landing page (yet).
     * @param array $get Curated GET.
     * @param array $post Curated POST.
     * @param array $files Curated FILES.
     * @return \View The View to be displayed.
     */
    public function call($get, $post, $files)
    {
        return new \Redirect("login");
    }
};