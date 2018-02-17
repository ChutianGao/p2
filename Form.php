<?php
namespace DWA;

class Form
{
    /**
     * Properties
     */
    private $request;
    public $hasErrors = false;

    /**
     * Form constructor.
     * @param $postOrGet
     */
    public function __construct($postOrGet)
    {
        # Store form data (POST or GET) in a class property called $request
        $this->request = $postOrGet;
    }

    /**
     * Returns True if *either* GET or POST have been submitted.
     * @return bool
     */
    public function isSubmitted()
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST' || !empty($_GET);
    }

    /**
     * Get a value from the request, with the option of including a default
     * if the value is not set.
     * @param $name
     * @param null $default
     * @return null
     */
    public function get($name, $default = null)
    {
        return $this->request[$name] ?? $default;
    }

    /**
     * Determines if a value is present in the request
     */
    public function has($name)
    {
        return isset($this->request[$name]) ? true : false;
    }

    /**
     * Use in display files to prefill the values of fields if those values are in the request.
     * Second optional parameter lets you set a default value if value does not exist
     * @param $field
     * @param string $default
     * @param bool $sanitize
     * @return array|string
     */
    public function prefill($field, $default = '', $sanitize = true)
    {
        if (isset($this->request[$field])) {
            if ($sanitize) {
                return $this->sanitize($this->request[$field]);
            } else {
                return $this->request[$field];
            }
        }

        return $default;
    }

    /**
     * Strips HTML characters; works with arrays or scalar values.
     * @param null $mixed
     * @return array|string
     */
    public function sanitize($mixed = null)
    {
        if (!is_array($mixed)) {
            return $this->convertHtmlEntities($mixed);
        }

        function arrayMapRecursive($callback, $array)
        {
            $func = function ($item) use (&$func, &$callback) {
                return is_array($item) ? array_map($func, $item) : call_user_func($callback, $item);
            };

            return array_map($func, $array);
        }

        return arrayMapRecursive('convertHtmlEntities', $mixed);
    }

    /**
     * Helper function used by sanitize
     * @param $mixed
     * @return string
     */
    private function convertHtmlEntities($mixed)
    {
        return htmlentities($mixed, ENT_QUOTES, "UTF-8");
    }

    /**
     * Given an array of fields => validation rules
     * Will loop through each field's rules
     * Returns an array of error messages
     * Stops after the first error for a given field
     * Available rules: alphaNumeric, alpha, numeric, required, email, min:x, max:x
     * @param $fieldsToValidate
     * @return array
     */
    public function validate($fieldsToValidate)
    {
        $errors = [];

        foreach ($fieldsToValidate as $fieldName => $rules) {
            # Each rule is separated by a |
            $rules = explode('|', $rules);

            foreach ($rules as $rule) {
                # Get the value for this field from the request
                $value = $this->get($fieldName);

                # Handle any parameters with the rule, e.g. max:99
                $parameter = null;
                if (strstr($rule, ':')) {
                    list($rule, $parameter) = explode(':', $rule);
                }

                # Run the validation test with the given rule
                $test = $this->$rule($value, $parameter);

                # Test failed
                if (!$test) {
                    $errors[] = 'The field ' . $fieldName . $this->getErrorMessage($rule, $parameter);

                    # Only indicate one error per field
                    break;
                }
            }
        }

        # Set public property hasErrors as Boolean
        $this->hasErrors = !empty($errors);

        return $errors;
    }

    /**
     * Given a String rule like 'alphaNumeric' or 'required'
     * It'll return a String message appropriate for that rule
     * Default message is used if no message is set for a given rule
     * @param $rule
     * @param null $parameter
     * @return mixed|string
     */
    private function getErrorMessage($rule, $parameter = null)
    {
        $language = [
            'alphaNumeric' => ' can only contain letters or numbers.',
            'alpha' => ' can only contain letters.',
            'numeric' => ' can only contain numbers.',
            'required' => ' can not be blank.',
            'email' => ' is not a valid email address.',
            'min' => ' has to be greater than ' . $parameter . '.',
            'max' => ' has to be less than ' . $parameter . '.',
        ];

        # If a message for the rule was found, use that, otherwise default to " has an error"
        $message = isset($language[$rule]) ? $language[$rule] : ' has an error.';

        return $message;
    }


    ### VALIDATION METHODS FOUND BELOW HERE ###

    /**
     * Returns boolean if given value contains only letters/numbers/spaces
     * @param $value
     * @return bool
     */
    protected function alphaNumeric($value)
    {
        return ctype_alnum(str_replace(' ', '', $value));
    }

    /**
     * Returns boolean if given value contains only letters/spaces
     * @param $value
     * @return bool
     */
    protected function alpha($value)
    {
        return ctype_alpha(str_replace(' ', '', $value));
    }

    /**
     * Returns boolean if given value contains only positive whole numbers
     * @param $value
     * @return bool
     */
    protected function numeric($value)
    {
        return ctype_digit(str_replace(' ', '', $value));
    }

    /**
     * Returns boolean if the given value is not blank
     * @param $value
     * @return bool
     */
    protected function required($value)
    {
        $value = trim($value);

        return $value != '' && isset($value) && !is_null($value);
    }

    /**
     * Returns boolean if the given value is a valid email address
     * @param $value
     * @return mixed
     */
    protected function email($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Returns value if the given value is GREATER THAN (non-inclusive) the given parameter
     * @param $value
     * @param $parameter
     * @return bool
     */
    protected function min($value, $parameter)
    {
        return floatval($value) > floatval($parameter);
    }

    /**
     * Returns value if the given value is LESS THAN (non-inclusive) the given parameter
     * @param $value
     * @param $parameter
     * @return bool
     */
    protected function max($value, $parameter)
    {
        return floatval($value) < floatval($parameter);
    }
}