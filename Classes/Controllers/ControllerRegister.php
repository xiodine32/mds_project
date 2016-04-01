<?php
/**
 * Created at: 29/03/16 12:34
 */

namespace Controllers;

use Controller;
use Models\ModelEmployee;

/**
 * Register Controller
 * @package Controllers
 */
class ControllerRegister extends Controller
{

    public function call($get, $post, $files)
    {
        $this->viewbag["title"] = "Register";

        if (!empty($post["username"])) {
            return $this->tryRegister($post['username'], $post['password'], $post['password2']);
        }
        return new \View();
    }

    /**
     * Try to register user.
     * @param $username string Username.
     * @param $password string Password.
     * @param $password2 string Password validation.
     * @return \View
     */
    private function tryRegister($username, $password, $password2)
    {
        // if user somehow thinks he's smart enough to disable javascript checking to troll us.
        if ($password !== $password2 || empty($username) || empty($password) || empty($password2)) {
            $this->viewbag['error'] = 'Passwords must match; username and password must not be empty!';
            return new \View();
        }

        // construct model
        $user = new ModelEmployee();
        $user->account = $username;
        $user->setPassword($password);

        // try to insert
        $databaseInsert = $user->insert();
        if ($databaseInsert) {

            // transform into the requested model.
            $user->select('account = ?', [$username]);

            // if authentication successfull
            if ($user->tryLogin($password))
                return new \Redirect("/main/");

            $this->viewbag['error'] = 'Please send a mail to the webmaster, something went horribly bad.';

            return new \View();
        }

        // could not insert, return error.
        $this->viewbag['error'] = 'Could not insert! <strong>' . print_r(\Database::instance()->lastError(), true) . "</strong>";
        
        return new \View();
    }
}

;