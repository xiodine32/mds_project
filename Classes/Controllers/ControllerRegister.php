<?php
/**
 * Created at: 29/03/16 12:34
 */

namespace Controllers;

use Controller;
use Models\ModelUser;

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

    private function tryRegister($username, $password, $password2)
    {
        if ($password !== $password2 || empty($username) || empty($password) || empty($password2)) {
            $this->viewbag['error'] = 'Passwords must match, username must not be empty and the same for the password!';
            return new \View();
        }

        $user = new ModelUser($username);
        $user->setPassword($password);

        $databaseInsert = $user->databaseInsert();
        if ($databaseInsert) {
            /** @var $user2 ModelUser */
            $user2 = ModelUser::databaseSelect('`username` = ?', [$username]);
            if ($user2->tryLogin($password))
                return new \Redirect("/main/");
            return new \View();
        }
        return new \View();
    }
}

;