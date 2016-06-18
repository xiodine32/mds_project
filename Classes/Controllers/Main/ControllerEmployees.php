<?php
/**
 * Created at: 01/04/16 15:19
 */

namespace Controllers\Main;


use Models\Generated\ModelDepartment;
use Models\Generated\ModelProject;
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
        $view = new \View();
        if ($this->has($request->post, "username")) {
            $view = $this->tryRegister($request->post);
        }
        if ($this->has($request->post, "link", "true")) {
            $view = $this->tryLinkDepartments($request->post);
        }
        if ($this->has($request->post, "linkProject", "true")) {
            $view = $this->tryLinkProjects($request->post);
        }
        $this->updateViewBag();
        return $view;
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

    private function tryLinkDepartments($post)
    {
        return $this->tryLinkEmployeeWithID($post, "department", "employee", "departmentID");
    }

    private function tryLinkEmployeeWithID($post, $to, $fromArray, $field)
    {
        if (empty($post[$to]))
            return new \View();
        $this->assure($post, $fromArray, []);
        $targetID = intval($post[$to]);
        if ($post[$to] === "null")
            $targetID = null;
        foreach ($post[$fromArray] as $employeeID) {
            $employee = new ModelEmployee();
            if (!$employee->select('employeeID = ?', [intval($employeeID)])) {
                return new \View();
            }
            $employee->$field = $targetID;
            if (!$employee->update()) {
                return new \View();
            }
        }
        return new \View();
    }

    private function tryLinkProjects($post)
    {
        return $this->tryLinkEmployeeWithID($post, "project", "employeeProject", "projectID");
    }

    private function updateViewBag()
    {
        $this->viewbag['employees'] = (new ModelEmployee())->selectAll();
        $this->viewbag['departments'] = (new ModelDepartment())->selectAll();
        $this->viewbag['projects'] = (new ModelProject())->selectAll();

        $newDepartment = new ModelDepartment();
        $newProject = new ModelProject();

        $this->viewbag['departments'][] = $newDepartment;
        $this->viewbag['projects'][] = $newProject;
    }

}