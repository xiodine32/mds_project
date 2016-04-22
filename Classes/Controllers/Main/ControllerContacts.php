<?php
/**
 * Created at: 01/04/16 15:18
 */

namespace Controllers\Main;


use Database;
use Models\Generated\ModelContact;

class ControllerContacts extends ControllerMain
{

    /**
     * Calls the controller to return a view, with employee assured to exist.
     * @param \Request $request
     * @return \View The View to be displayed.
     */
    protected function mainCall($request)
    {
        if ($this->has($request->post, 'reloadcontactID')) {

            $factories = \SmartModelFactory::instance()->factoryEmptyModelsFromQuery("Contacts", "SELECT Contacts.* FROM Projects 
RIGHT JOIN Contacts USING (contactID)");
            $options = ["<option value=\"\">--- NONE ---</option>"];
            if (is_array($factories)) {
                foreach ($factories as $item) {
                    $options[] = "<option value=\"{$item->contactID}\">{$item->contactName}</option>";
                }
            }
            return new \ViewHTML('<select class="" id="contactID" required name="contactID">' . join("\n", $options) . "</select>");
        }


        if ($this->hasMany($request->post, ["contactName"])) {
            return $this->tryAdd($request);
        }

        $this->viewbag['contacts'] = (new ModelContact())->selectAll();

        return new \View();
    }

    /**
     * @param $request \Request
     * @return \View
     *
     */
    private function tryAdd($request)
    {
        $keys = ["contactName", "phoneNumber", "faxNumber", "email", "physicalAddress"];

        $this->assureMany($request->post, $keys, null);

        $model = new ModelContact();

        foreach ($keys as $key) {
            $model->{$key} = $request->post[$key];
        }

//        echo "<pre>";var_dump($model);echo "</pre>";

        if (!$model->insert())
            $this->viewbag['error'] = Database::instance()->lastError();

        $this->viewbag['contacts'] = (new ModelContact())->selectAll();

        return new \View();
    }
}