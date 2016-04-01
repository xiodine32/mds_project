<?php
/**
 * Created at: 01/04/16 15:19
 */

namespace Controllers\Main;


use Models\ModelEmployee;

class ControllerEmployees extends ControllerMain
{

    /**
     * Calls the controller to return a view, with employee assured to exist.
     * @param array $get Curated GET.
     * @param array $post Curated POST.
     * @param array $files Curated FILES.
     * @return \View The View to be displayed.
     */
    protected function mainCall($get, $post, $files)
    {
        if ($this->is($post, "username")) {
            return $this->tryRegister($post);
        }
        return new \View();
    }

    private function tryRegister($post)
    {
        if ($post['password'] !== $post['password2'] || !$this->employee->administrator) {
            $this->viewbag['error'] = 'Error validating input';
            return new \View();
        }
        $m = new ModelEmployee();
        $m->account = $post['username'];
        $m->firstName = $post['firstName'];
        $m->middleInitial = $post['middleInitial'] ?: null;
        $m->lastName = $post['lastName'];
        $m->title = $post['title'];
        $m->cnp = $post['cnp'];
        $m->salary = $post['salary'];
        $m->priorSalary = $post['priorSalary'];
        $m->hireDate = $post['hireDate'];
        $m->administrator = 0;
        $m->setPassword($post['password']);
        if ($m->insert()) {
            $this->viewbag['success'] = 'User successfully inserted!';
            return new \View();
        }

        $this->viewbag['error'] = ' Error ' . \Database::instance()->lastError();
        return new \View();
    }
}