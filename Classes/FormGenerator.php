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

    private $view;

    /**
     * FormGenerator constructor.
     * @param View $view
     */
    public function __construct($view)
    {
        $this->view = $view;
        $this->generatedHTML = "";
        $this->generatedScripts = "";
    }


    /**
     * @param string $inputType Input type.
     * @param string $inputID ID text.
     * @param string $inputName Name text.
     * @param string $inputText Placeholder text.
     * @param string $inputErrorText Error text.
     * @param boolean|string $requiredType <b>TRUE</b> if input is required, <b>"TEXT"</b> if input is required and pattern requested, <b>FALSE</b> otherwise.
     * @param array [$options] can be:
     * <ul>
     * <li>'options' => [] ... for selects</li>
     * </ul>
     */
    public function addInput($inputType, $inputID, $inputName, $inputText, $inputErrorText, $requiredType, $options = [])
    {
        $labelClass = 'text-right middle' . ($this->error ? ' is-invalid-label' : '');
        $inputClass = ($this->error ? 'is-invalid-input' : '');

        $inputTypeText = $this->constructInput($inputType,
            $inputID,
            $inputText,
            $inputName,
            $options,
            $this->constructRequireAttribute($requiredType),
            $inputClass);

        if ($requiredType === "date") {
            $this->generatedScripts .= "<script>$(function() { $(\"#{$inputID}\").datepicker({inline:true, dateFormat: \"yy-mm-dd\"});});</script>\n";
        }

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

    }

    /**
     * Constructs the input, depending on $inputType.
     * @param string $inputType Input type.
     * @param string $inputID ID text.
     * @param string $inputText Placeholder text.
     * @param string $inputName Name text.
     * @param $options array can be:
     * <ul>
     * <li>'options' => [] ... for selects</li>
     * <li>name => "something" for different name</li>
     * </ul>
     * @param string $translatedRequired Required & pattern translated to attribute text.
     * @param $inputClass string Input classes.
     * @return string <ul>
     * <ul>
     * <li>'options' => [] ... for selects</li>
     * </ul>
     */
    private function constructInput($inputType, $inputID, $inputText, $inputName, $options, $translatedRequired, $inputClass)
    {
        $selected = !empty($options['value']) ? $options['value'] : "";
        if ($inputType === 'select') {

            $theOptions = isset($options['options']) ? $options['options'] : [];

            $optionsText = '<option value="">--- NONE ---</option>';

            foreach ($theOptions as $key => $value) {
                $text = "";
                if ($key == $selected)
                    $text = "selected";
                $optionsText .= "<option value='{$key}' {$text}>{$value}</option>\n";
            }

            return "<select name=\"{$inputName}\" id=\"{$inputID}\" class=\"{$inputClass}\" {$translatedRequired}>
{$optionsText}
</select>";
        }

        $maxlength = "";
        if (isset($options['maxlength']))
            $maxlength = "maxlength=\"{$options['maxlength']}\"";

        return "<input type=\"text\" name=\"{$inputName}\" placeholder=\"{$inputText}\" id=\"{$inputID}\"
                        {$translatedRequired} class=\"{$inputClass}\" {$maxlength} value=\"{$selected}\">";
    }   

    /**
     * Constructs required attribute for the given parameter.
     * @param boolean|string $requiredType <b>TRUE</b> if input is required, <b>"TEXT"</b> if input is required and pattern requested, <b>FALSE</b> otherwise.
     * @return string required attribute for HTML dom
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
     * Add a submit button.
     * @param string $classList Button class list.
     * @param string $buttonText Button text.
     * @param string $additionalTags
     */
    public function addSubmit($classList, $buttonText, $additionalTags = "")
    {
        $this->generatedHTML .= "<!-- Submit -->
            <div class=\"row\">
                <div class=\"small-3 columns\">
                    <label for=\"submitButton\"
                           class=\"text-right middle\">Submit: </label>
                </div>
                <div class=\"small-9 column\">
                    <button type=\"submit\" class=\"{$classList}\" id=\"submitButton\" {$additionalTags}>{$buttonText}</button>
                </div>
            </div>\n";
    }

    /**
     * Generate the form.
     * @return string Generated HTML for form.
     */
    public function generate()
    {
        if ($this->ajax)
            $this->generatedScripts = '<script>
    $(function () {
        var elemul = $("#' . $this->formID . '").find("form");
        new Foundation.Abide(elemul, {});
        var calledOnce = false;
        elemul.submit(function () {
            $(this).foundation("validateForm");
            return false;
        });
        elemul.on("formvalid.zf.abide", function () {
            if (calledOnce) return;
            calledOnce = true;
            console.log("called");
            var form = $(this).serialize();
            $.post("' . $this->action . '", form, function () {
                if (window.quickAdd)
                    window.quickAdd.close();
            });
        });
    });
</script>';
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
        <h3 class=\"text-center\">{$this->title}</h3>
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

    public function addCustomBegin()
    {
        ob_start();
    }

    public function addCustomEnd()
    {
        $content = ob_get_contents();
        ob_end_clean();
        $this->generatedHTML .= $content;
    }


}