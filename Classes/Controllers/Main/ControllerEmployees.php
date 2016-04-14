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
     * @param \Request $request
     * @return \View The View to be displayed.
     */
    protected function mainCall($request)
    {
        if ($this->has($request->post, "username")) {
            return $this->tryRegister($request->post);
        }
        return new \View();
    }

    private function tryRegister($post)
    {
        if ($post['password'] !== $post['password2'] || !$this->employee->administrator) {
            $this->viewbag['error'] = 'Error validating input';
            return new \View();
        }
        $employee = new ModelEmployee();
        $employee->account = $post['username'];
        $employee->firstName = $post['firstName'];
        $employee->middleInitial = $post['middleInitial'] ?: null;
        $employee->lastName = $post['lastName'];
        $employee->title = $post['title'];
        $employee->cnp = $post['cnp'];
        $employee->salary = $post['salary'];
        $employee->priorSalary = $post['priorSalary'];
        $employee->hireDate = $post['hireDate'];
        $employee->administrator = 0;
        $employee->setPassword($post['password']);
        if ($employee->insert()) {
            $this->viewbag['success'] = 'User successfully inserted!';
            return new \View();
        }

        $this->viewbag['error'] = \Database::instance()->lastError();
        return new \View();
    }
}