<?php

/**
 * Created at: 05/04/16 17:37
 */
class FormGenerator
{

    public $title;
    public $formID;


    public $errorMessage;
    public $error;

    public $success;
    public $successMessage;


    public $show;
    public $action;
    public $ajax;

    private $generatedHTML;
    private $generatedScripts;

    /**
     * FormGenerator constructor.
     */
    public function __construct()
    {
        $this->generatedHTML = "";
        $this->generatedScripts = "";
    }


    /**
     * @param string $inputType
     * @param string $inputID
     * @param string $inputText
     * @param string $inputErrorText
     * @param boolean|string $requiredType
     * @param array [$options]
     */
    public function addInput($inputType, $inputID, $inputText, $inputErrorText, $requiredType, $options = [])
    {
        $labelClass = 'text-right middle' . ($this->error ? ' is-invalid-label' : '');
        $inputClass = ($this->error ? 'is-invalid-input' : '');

        $inputTypeText = $this->constructInput($inputType,
            $inputID,
            $inputText,
            $options,
            $this->constructRequireAttribute($requiredType),
            $inputClass);

        $this->generatedHTML .= "<!-- {$inputID} -->
<div class=\"row\">
    <div class=\"small-3 columns\">
        <label for=\"{$inputID}\"
               class=\"{$labelClass}\">{$inputText}: </label>
    </div>
    <div class=\"small-9 columns\">
        {$inputTypeText}
        <span class=\"form-error\">{$inputErrorText}</span>
    </div>
</div>\n";

        if ($requiredType === "date") {
            $this->generatedScripts .= "<script>(function() { $('#{$inputID}').datepicker({inline:true, dateFormat: 'yy-mm-dd'});})();</script>\n";
        }

    }

    /**
     * @param string $inputType
     * @param string $inputID
     * @param string $inputText
     * @param array $options
     * @param string $translatedRequired
     * @param string $inputClass
     * @return string
     */
    private function constructInput($inputType, $inputID, $inputText, $options, $translatedRequired, $inputClass)
    {

        if ($inputType === 'select') {

            $theOptions = isset($options['options']) ? $options['options'] : [];

            $optionsText = '<option value="">--- NONE ---</option>';

            foreach ($theOptions as $key => $value) {
                $optionsText .= "<option value='{$key}'>{$value}</option>\n";
            }

            return "<select name=\"{$inputID}\" id=\"{$inputID}\" class=\"{$inputClass}\" {$translatedRequired}>
{$optionsText}
</select>";
        }

        if ($inputType === 'date') {
            return "<input type=\"date\" name=\"{$inputID}\" placeholder=\"{$inputText}\" id=\"{$inputID}\"
                        {$translatedRequired} class=\"{$inputClass}\">";
        }

        return "<input type=\"text\" name=\"{$inputID}\" placeholder=\"{$inputText}\" id=\"{$inputID}\"
                        {$translatedRequired} class=\"{$inputClass}\">";
    }

    /**
     * @param boolean|string $requiredType
     * @return string
     */
    private function constructRequireAttribute($requiredType)
    {
        $requiredAttribute = 'required';

        if (!$requiredType) {
            return '';
        }

        if ($requiredType === true) {
            return $requiredAttribute;
        }

        return $requiredAttribute . " pattern=\"{$requiredType}\"";
    }

    /**
     * @param string $classList
     * @param string $buttonText
     */
    public function addSubmit($classList, $buttonText)
    {
        $this->generatedHTML .= "<!-- Submit -->
            <div class=\"row\">
                <div class=\"small-3 columns\">
                    <label for=\"submitButton\"
                           class=\"text-right middle\">Submit: </label>
                </div>
                <div class=\"small-9 column\">
                    <button type=\"submit\" class=\"{$classList}\" id=\"submitButton\">{$buttonText}</button>
                </div>
            </div>\n";
    }

    /**
     * @return string
     */
    public function generate()
    {

        $successText = "";
        if ($this->success)
            $successText = "<div class=\"callout success\">{$this->successMessage}</div>";


        $errorStyle = "display:none";
        $errorRole = '';
        if ($this->error) {
            $errorStyle = "display:block;";
            $errorRole = "role=\"alert\"";
        }

        return "<section id=\"{$this->formID}\">
        <h3 class=\"text-center\">Register new contact</h3>
        {$successText}
        <form action=\"{$this->action}\" method=\"post\" data-abide novalidate>
            <div data-abide-error class=\"alert callout\" style=\"{$errorStyle}\" {$errorRole}>
                <p><i class=\"fi-alert\"></i> {$this->errorMessage}
                </p>
            </div>
{$this->generatedHTML}
        </form>
        {$this->generatedScripts}
        </section>";
    }


}