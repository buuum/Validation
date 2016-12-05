<?php

namespace Buuum;


class Validation
{

    /**
     * @var bool
     */
    private $error = false;
    /**
     * @var array
     */
    private $errors = [];
    /**
     * @var array
     */
    private $keyerrors = [];
    /**
     * @var array
     */
    private $apply_rules = [];
    /**
     * @var array|mixed
     */
    private $messages = [];
    /**
     * @var array|null
     */
    private $alias = [];

    /**
     * @var array
     */
    private $special = ['required'];

    /**
     * @var string
     */
    private $alpha = 'a-zÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿçÇñÑ';

    /**
     * Validation constructor.
     * @param $rules
     * @param array|null $messages
     * @param null $alias
     */
    public function __construct($rules, array $messages = null, $alias = null)
    {
        $this->apply_rules = $this->parseRules($rules);
        $this->messages = $messages ?: include __DIR__ . '/messages.php';
        $this->alias = $alias;
    }

    /**
     * @param $data
     * @return bool
     */
    public function validate($data)
    {
        foreach ($this->apply_rules as $name => $rules) {

            foreach ($rules as $filter_function => $params) {

                if (!isset($data[$name])) {
                    if (array_key_exists('validate_required', $rules)) {
                        $this->setError($filter_function, $name, $params);
                    }
                } elseif (is_array($data[$name]) && !in_array($filter_function, $this->special)) {
                    foreach ($data[$name] as $key => $data_) {
                        if (empty($data_) && !array_key_exists('validate_required', $rules)) {
                        } elseif (!$value = call_user_func(array($this, $filter_function), $data_, $data, $params)) {
                            $this->setError($filter_function, $name, $params, $key);
                        }
                    }
                } else {
                    if (empty($data[$name]) && !array_key_exists('validate_required', $rules)) {
                    } elseif (!$value = call_user_func(array($this, $filter_function), $data[$name], $data, $params)) {
                        $this->setError($filter_function, $name, $params);
                    }
                }

            }
        }

        return ($this->error) ? false : true;
    }

    /**
     * @param $fname
     * @param $name
     * @param $value
     * @param null $key
     */
    private function setError($fname, $name, $value, $key = null)
    {
        $message_key = str_replace('validate_', '', $fname);

        if (!empty($this->messages[$message_key . ':' . $name])) {
            $error = $this->messages[$message_key . ':' . $name];
        } else {
            $error = $this->messages[$message_key];
        }
        if (is_array($error)) {
            $type = array_shift($value);
            $error = $error[$type];
        }
        $alias = (!empty($this->alias[$name])) ? $this->alias[$name] : $name;
        $error = str_replace(':attribute', $alias, $error);
        if ($value) {
            $error = str_replace(':value', implode(',', $value), $error);
        }

        if (!is_null($key)) {
            $this->errors[$alias][$key][] = $error;
            $this->keyerrors[$name][$key][] = $error;
        } else {
            $this->errors[$alias][] = $error;
            $this->keyerrors[$name][] = $error;
        }
        $this->error = true;

    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return array
     */
    public function getErrorsWithKey()
    {
        return $this->keyerrors;
    }

    /**
     * @return array
     */
    public function getErrorKeys()
    {
        return array_keys($this->keyerrors);
    }

    /**
     * @param $rules
     * @return array
     */
    protected function parseRules($rules)
    {
        $apply_rules = [];
        foreach ($rules as $name => $rule) {
            if (!empty($rule)) {
                $apply_rules[$name] = $this->getNameRules($rule);
            }
        }

        return $apply_rules;
    }

    /**
     * @param $rules
     * @return array
     */
    private function getNameRules($rules)
    {
        $rules = explode('|', $rules);
        $p_rules = [];
        foreach ($rules as $rule) {
            $params = null;
            $name = 'validate_' . $rule;
            if (strpos($rule, ':') !== false) {
                $params = explode(':', $rule, 2);
                $name = 'validate_' . $params[0];
                $params = (!empty($params[1])) ? explode(':', $params[1]) : null;
            }

            $p_rules[$name] = $params;
        }
        return $p_rules;
    }

    /**
     * @param $value
     * @return bool
     */
    protected function validate_required($value)
    {
        if (is_null($value)) {
            return false;
        } elseif (is_string($value) && trim($value) === '') {
            return false;
        }

        return true;
    }

    /**
     * @param $value
     * @param $data
     * @param $param
     * @return bool
     */
    protected function validate_contains($value, $data, $param)
    {

        $params = array_map(function ($element) {
            return trim(strtolower($element));
        }, $param);

        $val = trim(strtolower($value));

        if (!in_array($val, $params)) { // valid, return nothing
            return false;
        }

        return true;
    }

    /**
     * @param $value
     * @return bool
     */
    protected function validate_valid_email($value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }

    /**
     * @param $value
     * @param $data
     * @param $param
     * @return bool
     */
    protected function validate_max($value, $data, $param)
    {
        return $this->getSize($value) <= $param[0];
    }

    /**
     * @param $value
     * @return int
     */
    protected function getSize($value)
    {
        if (is_numeric($value)) {
            return $value;
        } elseif (is_array($value)) {
            return count($value);
        } else {
            if (function_exists('mb_strlen')) {
                return mb_strlen($value);
            } else {
                return strlen($value);
            }
        }
    }

    /**
     * @param $value
     * @param $data
     * @param $param
     * @return bool
     */
    protected function validate_min($value, $data, $param)
    {
        return $this->getSize($value) > $param[0];
    }

    /**
     * @param $value
     * @param $data
     * @param $param
     * @return bool
     */
    protected function validate_exact_len($value, $data, $param)
    {
        if (function_exists('mb_strlen')) {
            $value = mb_strlen($value);
        } else {
            $value = strlen($value);
        }
        return $value == $param[0];
    }

    /**
     * @param $value
     * @param $only
     * @return bool
     */
    protected function validate_alpha($value, $data, $only = false)
    {
        if (empty($value)) {
            return false;
        }

        $regex = ($only) ? 'a-z' : $this->alpha;

        if (!preg_match('/^([' . $regex . '])+$/i', $value) !== false) {
            return false;
        }

        return true;
    }

    /**
     * @param $value
     * @return bool
     */
    protected function validate_only_alpha($value)
    {
        return $this->validate_alpha($value, [], true);
    }

    /**
     * @param $value
     * @param $only
     * @return bool
     */
    protected function validate_alpha_space($value, $data, $only = false)
    {
        if (empty($value)) {
            return false;
        }

        $regex = ($only) ? 'a-z' : $this->alpha;

        if (!preg_match("/^([" . $regex . "\s])+$/i", $value) !== false) {
            return false;
        }

        return true;
    }

    /**
     * @param $value
     * @return bool
     */
    protected function validate_only_alpha_space($value)
    {
        return $this->validate_alpha_space($value, [], true);
    }

    /**
     * @param $value
     * @param $only
     * @return bool
     */
    protected function validate_alpha_dash($value, $data, $only = false)
    {
        if (empty($value)) {
            return false;
        }

        $regex = ($only) ? 'a-z' : $this->alpha;

        if (!preg_match('/^([' . $regex . '_-])+$/i', $value) !== false) {
            return false;
        }

        return true;
    }

    /**
     * @param $value
     * @return bool
     */
    protected function validate_only_alpha_dash($value)
    {
        return $this->validate_alpha_dash($value, [], true);
    }

    /**
     * @param $value
     * @param $only
     * @return bool
     */
    protected function validate_alpha_numeric($value, $data, $only = false)
    {
        if (empty($value)) {
            return false;
        }

        $regex = ($only) ? 'a-z' : $this->alpha;

        if (!preg_match('/^([0-9' . $regex . '])+$/i', $value) !== false) {
            return false;
        }

        return true;
    }

    /**
     * @param $value
     * @return bool
     */
    protected function validate_only_alpha_numeric($value)
    {
        return $this->validate_alpha_numeric($value, [], true);
    }

    /**
     * @param $value
     * @param $only
     * @return bool
     */
    protected function validate_alpha_numeric_dash($value, $data, $only = false)
    {
        if (empty($value)) {
            return false;
        }

        $regex = ($only) ? 'a-z' : $this->alpha;

        if (!preg_match('/^([0-9' . $regex . '_-])+$/i', $value) !== false) {
            return false;
        }

        return true;
    }

    /**
     * @param $value
     * @return bool
     */
    protected function validate_only_alpha_numeric_dash($value)
    {
        return $this->validate_alpha_numeric_dash($value, [], true);
    }

    /**
     * @param $value
     * @param $data
     * @param $only
     * @return bool
     */
    protected function validate_alpha_numeric_space($value, $data, $only = false)
    {
        if (empty($value)) {
            return false;
        }

        $regex = ($only) ? 'a-z' : $this->alpha;

        if (!preg_match('/^([0-9' . $regex . '\s])+$/i', $value) !== false) {
            return false;
        }

        return true;
    }

    /**
     * @param $value
     * @return bool
     */
    protected function validate_only_alpha_numeric_space($value)
    {
        return $this->validate_alpha_numeric_space($value, [], true);
    }

    /**
     * @param $value
     * @return bool
     */
    protected function validate_numeric($value)
    {

        if (!is_numeric($value)) {
            return false;
        }

        return true;
    }

    /**
     * @param $value
     * @return bool
     */
    protected function validate_integer($value)
    {

        if (filter_var($value, FILTER_VALIDATE_INT) === false) {
            return false;
        }

        return true;
    }

    /**
     * @param $value
     * @return bool
     */
    protected function validate_url($value)
    {
        if (empty($value)) {
            return false;
        }

        if (filter_var($value, FILTER_VALIDATE_URL) === false) {
            return false;
        }

        return true;
    }

    /**
     * @param $value
     * @param $data
     * @param $param
     * @return bool
     */
    protected function validate_equals($value, $data, $param)
    {
        if (empty($data[$param[0]])) {
            return false;
        }
        if ($data[$param[0]] != $value) {
            return false;
        }

        return true;
    }

    /**
     * @param $value
     * @param $data
     * @param $param
     * @return bool
     */
    protected function validate_groupdate($value, $data, $param)
    {
        if (empty($data[$param[0]]) || empty($data[$param[1]]) || empty($data[$param[2]])) {
            return false;
        }

        //$date = $data[$param[0]] . '-' . $data[$param[1]] . '-' . $data[$param[2]];
        //$d = \DateTime::createFromFormat('Y-m-d', $date);
        //return $d && ($d->format('Y-m-d') === $date || $d->format('Y-n-d') == $date || $d->format('Y-m-j') == $date || $d->format('Y-n-j') == $date);
        return checkdate($data[$param[1]], $data[$param[2]], $data[$param[0]]);
    }

    /**
     * @param $value
     * @param $data
     * @param $param
     * @return bool
     */
    protected function validate_date($value, $data, $param)
    {
        $format = implode(':', $param);
        $d = \DateTime::createFromFormat($format, $value);
        return $d && ($d->format($format) === $value);
    }

}