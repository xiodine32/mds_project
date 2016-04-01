<?php
/**
 * Created at: 29/03/16 12:34
 */

namespace Controllers;

use Controller;
use Models\ModelEmployee;

/**
 * Login Controller
 * @package Controllers
 */
class ControllerLogin extends Controller
{

    /**
     * Calls the controller
     * @param array $get Curated GET.
     * @param array $post Curated POST.
     * @param array $files Curated FILES.
     * @return \View The View to be displayed.
     */
    public function call($get, $post, $files)
    {

        // if user already logged in, redirect to main content
        if (ModelEmployee::fromSession() !== false)
            return new \Redirect("/main/");

        // set title
        $this->viewbag["title"] = "Login";

        // if login request, try to login user
        if (!empty($post['username'])) {
            return $this->tryLogin($post['username'], $post['password']);
        }

        // display standard content
        return new \View();
    }

    /**
     * Try to login user.
     * @param $username string Username.
     * @param $password string Password.
     * @return \View The View to be displayed.
     */
    private function tryLogin($username, $password)
    {
        // Cheeky bastard skips javascript validation?
        if (empty($username) || empty($password)) {
            $this->viewbag['error'] = 'Empty username / password';
            return new \View();
        }

        $user = new ModelEmployee();

        // find user with account name
        if (!$user->select('account = ?', [$username])) {
            $this->viewbag['error'] = 'User not found';
            return new \View();
        }

        // try to login
        if (!$user->tryLogin($password)) {
            $this->viewbag['error'] = 'Wrong username / password';
            return new \View();
        }

        return new \Redirect("main/");
    }
}

;