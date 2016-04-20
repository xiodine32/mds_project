<?php
/**
 * Created at: 20/04/16 11:30
 */

namespace Controllers\Main;


abstract class ControllerCRUD extends ControllerMain
{
    protected $modelName;
    private $theThis;

    public function __construct($theThis, $modelName)
    {
        parent::__construct();
        $this->theThis = $theThis;
        $this->modelName = $modelName;

    }


    /**
     * Calls the controller to return a view, with employee assured to exist.
     * @param \Request $request
     * @return \View The View to be displayed.
     */
    protected function mainCall($request)
    {
        if (!$this->employee->administrator)
            return new \Redirect("/");

        $this->viewbag['model'] = $this->modelName;

        return new \View("view.php");
    }
}