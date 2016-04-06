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
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Calls the controller
     * @param \Request $request
     * @return \View The View to be displayed.
     */
    public function call($request)
    {

        // if user already logged in, redirect to main content
        $employee = ModelEmployee::fromSession($request);
        if ($employee !== false)
            return new \Redirect("/main/");

        // set title
        $this->viewbag["title"] = "Login";

        // if login request, try to login user
        if (!empty($request->post['username'])) {
            return $this->tryLogin($request->post['username'], $request->post['password'], $request);
        }

        // display standard content
        return new \View();
    }

    /**
     * Try to login user.
     * @param $username string Username.
     * @param $password string Password.
     * @param \Request $request
     * @return \View The View to be displayed.
     */
    private function tryLogin($username, $password, $request)
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
        if (!$user->tryLogin($password, $request)) {
            $this->viewbag['error'] = 'Wrong username / password';
            return new \View();
        }

        return new \Redirect("main/");
    }
}

;