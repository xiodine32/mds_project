<?php
/**
 * Created at: 29/03/16 12:34
 */

namespace Controllers;

use Controller;
use Models\ModelEmployee;

class ControllerLogin extends Controller
{

    public function call($get, $post, $files)
    {
        if (ModelEmployee::fromSession() !== false)
            return new \Redirect("/main/");
        $this->viewbag["title"] = "Login";

        if (!empty($post['username'])) {
            return $this->tryLogin($post['username'], $post['password']);
        }

        return new \View();
    }

    /**
     * @param $username
     * @param $password
     * @return \View
     */
    private function tryLogin($username, $password)
    {
        if (empty($username) || empty($password)) {
            $this->viewbag['error'] = 'Empty username / password';
            return new \View();
        }

        /** @var \Models\ModelEmployee $user */
        $user = ModelEmployee::databaseSelect('account = ?', [$username]);
//        var_dump($user);
        if (!$user) {
            $this->viewbag['error'] = 'User not found';
            return new \View();
        }
        if ($user->tryLogin($password)) {
            return new \Redirect("main/");
        }
        $this->viewbag['error'] = 'Wrong username / password';
        return new \View();
    }
}

;