<?php

namespace RequestCheck\Validations;

class ValidRegex extends AbstractValidation
{

    const NUMERIC = '@^([0-9])+$@i';
    const ALPHA = '@^([a-zÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿçÇñÑ])+$@i';
    const ALPHA_NUMERIC = '@^([a-zÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿçÇñÑ0-9])+$@i';
    const ALPHA_SPACE = '@^([a-zÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿçÇñÑ\s])+$@i';
    const ALPHA_NUMERIC_SPACE = '@^([a-zÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿçÇñÑ0-9\s])+$@i';
    const SLUG = '@^([a-z0-9_-])+$@i';

    private $regex;

    public function __construct($regex, $message = false)
    {
        if (@preg_match($regex, null) === false) {
            throw new \Exception('Invalid Regex ' . $regex . ' in ' . get_class($this));
        }

        $this->regex = $regex;
        parent::__construct($message);
    }

    public function validate($value)
    {
        if (empty($value)) {
            return false;
        }

        if (!preg_match($this->regex, $value) !== false) {
            return false;
        }
        return true;
    }

    public function getVars()
    {
        return [
            'regex' => $this->regex
        ];
    }

}