Filter and Validation data input
================================

[![Packagist](https://img.shields.io/packagist/v/buuum/validation.svg)](https://packagist.org/packages/buuum/validation)
[![license](https://img.shields.io/github/license/mashape/apistatus.svg?maxAge=2592000)](#license)

## Install

### System Requirements

You need PHP >= 5.5.0 to use Buuum\validation but the latest stable version of PHP is recommended.

### Composer

Buuum\validation is available on Packagist and can be installed using Composer:

```
composer require buuum/validation
```

### Manually

You may use your own autoloader as long as it follows PSR-0 or PSR-4 standards. Just put src directory contents in your vendor directory.


### FILTERS

* trim `Strip whitespace from the beginning and end of a string`
* sanitize_string `Strip tags`
* sanitize_email `Remove all characters except letters, digits and !#$%&'*+-=?^_{|}~@.[].`
* rmpunctuation `Remove all known punctuation characters from a string`
* urlencode `Encode url entities`
* htmlencode `Encode HTML entities`
* sanitize_numbers `Remove any non-numeric characters`
* tags `Remove all layout orientated HTML tags from text. Leaving only basic tags`
* custom_tags `Remove HTML tags except declared`
* attributes `Remove all attributes tags`
* whole_number `Ensure that the provided numeric value is represented as a whole number`
 
### USE FILTER

```php

$filter_rules = [
    'name'  => 'trim|sanitize_string',
    'email' => 'trim|sanitize_email',
];

$data = [
    'name' => ' name ',
    'email' => ' (email@email.com) '
];
$filter = new Filter($filter_rules);

$data = $fitler->filter($data);

// output
$data = [
    'name' => 'name',
    'email' => 'email@email.com'
];
```
 
## VALIDATORS

* required
* contains `contains:word1:word2`
* valid_email
* max `max:23`
* min `min:3`
* exact_len `exact_len:5`
* max_len `max_len:23`
* min_len `min_len:3`
* alpha  
* alpha_space
* alpha_dash
* alpha_numeric
* alpha_numeric_space
* alpha_numeric_dash
* only_alpha  
* only_alpha_space
* only_alpha_dash
* only_alpha_numeric
* only_alpha_numeric_space
* only_alpha_numeric_dash
* numeric
* integer
* euqals `equals:password2`
* date `date:Y-m-d` date:formatdate
* groupdate `groupdate:ano:mes:dia`
* url

####NOTE
Group Alpha 
with prefix only_ = a-z
without prefix = a-zÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿçÇñÑ

### USE VALIDATORS

```php
$validator_rules = [
    'name' => 'required|max:20',
    'email' => 'required|valid_email',
    'date' => 'date:d/m/Y',
    'dia'      => 'required|integer',
    'mes'      => 'required|integer',
    'ano'      => 'required|integer|groupdate:ano:mes:dia',
];

$messages = [
    "required"      => "The :attribute is required",
    "required:email"      => "Email required",
    "max"           => "The :attribute may not be greater than :value.",
    "valid_email"   => "The :attribute format is invalid.",
    "date"          => "La fecha seleccionada es incorrecta.",
    "groupdate"     => "La fecha seleccionada es incorrecta."
];

$validator = new Validation($validator_rules, $messages);

$data = [
    'name' => '',
    'email' => ''
];

$errors = $validator->validate($data);

//outpur errors

Array
(
    [name] => Array
        (
            [0] => The name is required
        )
        
    [email] => Array
        (
            [0] => The email is required
            [1] => The email format is invalid.
        )
);

```

 
## LICENSE

The MIT License (MIT)

Copyright (c) 2016

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.