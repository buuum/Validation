<?php

namespace Buuum;


class Filter
{

    /**
     * @var array
     */
    private $apply_rules = [];

    /**
     * Filter constructor.
     * @param $rules
     */
    public function __construct($rules)
    {
        $this->parseRules($rules);
    }

    /**
     * @param $data
     * @return array
     */
    public function filter($data)
    {
        $data_filter = [];
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data_filter[$key] = $this->filter_values($key, $value);
            } else {
                $data_filter[$key] = $this->filter_value($key, $value);
            }
        }
        return $data_filter;
    }

    /**
     * @param $rules
     */
    protected function parseRules($rules)
    {
        foreach ($rules as $name => $rule) {
            $this->apply_rules[$name] = $this->getNameRules($rule);
        }
    }

    /**
     * @param $key
     * @param $values
     * @return array
     */
    protected function filter_values($key, $values)
    {
        $fiter_arr = [];
        foreach ($values as $value) {
            $fiter_arr[] = $this->filter_value($key, $value);
        }
        return $fiter_arr;
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    protected function filter_value($key, $value)
    {
        if (!empty($this->apply_rules[$key])) {
            foreach ($this->apply_rules[$key] as $filter_function => $params) {
                $value = call_user_func(array($this, $filter_function), $value, $params);
            }
        }
        return $value;
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
            $params = explode(':', $rule, 2);
            $name = 'filter_' . $params[0];
            $params = (!empty($params[1])) ? explode(':', $params[1]) : null;
            $p_rules[$name] = $params;
        }
        return $p_rules;
    }

    /**
     * @param $value
     * @return string
     */
    protected function filter_trim($value)
    {
        return trim($value);
    }

    /**
     * @param $value
     * @return mixed
     */
    protected function filter_sanitize_string($value)
    {
        return filter_var($value, FILTER_SANITIZE_STRING);
    }

    /**
     * @param $value
     * @return mixed
     */
    protected function filter_rmpunctuation($value)
    {
        return preg_replace("/(?![.=$'€%-])\p{P}/u", '', $value);
    }

    /**
     * @param $value
     * @return mixed
     */
    protected function filter_urlencode($value)
    {
        return filter_var($value, FILTER_SANITIZE_ENCODED);
    }

    /**
     * @param $value
     * @return mixed
     */
    protected function filter_htmlencode($value)
    {
        return filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    /**
     * @param $value
     * @return mixed
     */
    protected function filter_sanitize_email($value)
    {
        return filter_var($value, FILTER_SANITIZE_EMAIL);
    }

    /**
     * @param $value
     * @return mixed
     */
    protected function filter_sanitize_numbers($value)
    {
        return filter_var($value, FILTER_SANITIZE_NUMBER_INT);
    }

    /**
     * @param $value
     * @return string
     */
    protected function filter_tags($value)
    {
        return strip_tags($value);
    }

    /**
     * @param $value
     * @param $tags
     * @return string
     */
    protected function filter_custom_tags($value, $tags)
    {
        $tags = implode('', $tags);
        return strip_tags($value, $tags);
    }

    /**
     * @param $value
     * @return mixed
     */
    protected function filter_attributes($value)
    {
        return preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i", '<$1$2>', $value);
    }

    /**
     * @param $value
     * @return int
     */
    protected function filter_whole_number($value)
    {
        return intval($value);
    }

}