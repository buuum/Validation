Filter and Validation data input
================================

[![Packagist](https://img.shields.io/packagist/v/buuum/requestcheck.svg)](https://packagist.org/packages/buuum/requestcheck)
[![license](https://img.shields.io/github/license/mashape/apistatus.svg?maxAge=2592000)](#license)

## Install

### System Requirements

You need PHP >= 7.1.0 to use Buuum\RequestCheck but the latest stable version of PHP is recommended.

### Composer

Buuum\RequestCheck is available on Packagist and can be installed using Composer:

```
composer require buuum/requestcheck
```

### Manually

You may use your own autoloader as long as it follows PSR-0 or PSR-4 standards. Just put src directory contents in your vendor directory.

### INPUT FIELDS

#### INPUT
```php
$name = new Input('name');
$name->setFilters([new FilterTrim()]);
$name->setValidations([new ValidRequired()]);
```
#### INPUTOBJECT
```php
$name = new Input('name');
$name->setFilters([new FilterTrim()]);
$name->setValidations([new ValidRequired()]);

$url = new Input('url');
$url->setValidations([new ValidRequired()]);

$imageobject = new InputObject('image', new InputCollection([$name, $url]));
$imageobject->setValidations([new ValidRequired()]);

```
#### INPUTARRAY
```php

// Simple Array
$url = new Input('url');
$url->setValidations([new ValidRequired()]);

$urls = new InputArray('urls', $url);
$urls->setValidations([new ValidRequired()]);

// Array objects
...
$images = new InputArray('urls', $imageobject);

// Array arrays
...
$images_array = new InputArray('images_array', $images);
```

### HOW TO USE
```php
$data = [
    'name'        => '   dr  r rwe wed   ',
    'url'         => ' url',
];
$fields = [$name, $url];
$request = new RequestCheck($data, new InputCollection($fields));

// return data filtered 
$data_filtered = $request->filter();

// return RequestResponse
$response = $request->validate();

if($response->isValid()){
    // no errors
}else{
    var_dump($response->getErrors());
}
```

### FILTERS

#### Attributes
remove all attributes
```php
...
$name->setFilters([new FilterAttributes()]);
```

#### Custom Tags
remove custom tags
- param1: allow tags 
```php
...
$name->setFilters([new FilterCustomTags('<p><a>')]);
```

#### Email
return filter email
```php
...
$name->setFilters([new FilterEmail()]);
```

#### HtmlEncode
return htmlencode data
```php
...
$name->setFilters([new FilterHtmlEncode()]);
```

#### RemovePunctuation
remove punctuation
```php
...
$name->setFilters([new FilterRemovePunctuation()]);
```

#### Sanitize Number
sanitize number data
```php
...
$name->setFilters([new FilterSanitizeNumber()]);
```

#### String
sanitize string data
```php
...
$name->setFilters([new FilterString()]);
```

#### Trim
trim data
```php
...
$name->setFilters([new FilterTrim()]);
```

#### UrlEncode
encode url
```php
...
$name->setFilters([new FilterUrlEncode()]);
```

#### Whole Number
whole number
```php
...
$name->setFilters([new FilterWholeNumber()]);
```

### Create custom filter
```php
class FilterLetter implements Filter
{
    
    protected $letter;
    
    public function __construct($letter)
    {
        $this->letter = $letter;
    }

    public function filter($data)
    {
        return str_replace($this->letter,'', $data);
    }
}
...
$name->setFilters([new FilterLetter('a')]);
```
 
## VALIDATORS

### REQUIRED
Check if input exists
- param1: string (custom message)
```php
...
$name->setValidations([new ValidRequired()]);
```

### Email
Check if input is a valid email
- param1: string (custom message)
```php
...
$name->setValidations([new ValidEmail()]);

### Integer
Check if input is a valid integer
- param1: string (custom message)
```php
...
$name->setValidations([new ValidInteger()]);
```

### Exact
Check if input value is exact to value
- param1: int value to exact
- param2: string (custom message)
```php
...
$name->setValidations([new ValidExact(34)]);
```

### MAX
Check if input value is max
- param1: int value max
- param2: string (custom message)
```php
...
$name->setValidations([new ValidExact(34)]);
```

### MIN
Check if input value is min
- param1: int value min
- param2: string (custom message)
```php
...
$name->setValidations([new ValidMin(34)]);
```


### REGEX
Check if input is valid with regex
- param1: string regex
- param2: string (custom message)
##### PREDEFINE REGEXS:
- NUMERIC
- ALPHA
- ALPHA_NUMERIC
- ALPHA_SPACE
- ALPHA_NUMERIC_SPACE
- SLUG

```php
...
$name->setValidations([new ValidRegex(ValidRegex::NUMERIC)]);
```

### URL
Check if input is valid url
- param1: string (custom message)
```php
...
$name->setValidations([new ValiUrl(34)]);
```

### Contains
Check if string contains any value of array
- param1: array
- param2: string (custom message)
```php
...
$words = ['blue', 'yellow'];
$name->setValidations([new ValidContains($words)]);
```

### Date
Check if input is a valid date
- param1: string date format
- param2: string (custom message)
```php
...
$format = 'Y/m/d';
$name->setValidations([new ValidDate($format)]);
```

## LICENSE

The MIT License (MIT)

Copyright (c) 2017

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.