<?php

namespace Errors;

use RequestCheck\Validations\ValidContains;
use RequestCheck\Validations\ValidEmail;
use RequestCheck\Validations\ValidExact;
use RequestCheck\Validations\ValidMax;
use RequestCheck\Validations\ValidMin;
use RequestCheck\Validations\ValidRequired;
use RequestCheck\Validations\ValidUrl;

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    ValidRequired::class       => "The :attribute is required",
    ValidUrl::class            => "The :attribute value must be valid url",
    ValidMax::class            => "The :attribute may not be greater than :value.",
    ValidMin::class            => "The :attribute must be at least :value.",
    ValidContains::class       => "The :attribute must be :value.",
    ValidExact::class          => "The :attribute must be exact :value.",
    "exact_len"                => "The :attribute len must be :value",
    "max_len"                  => "The :attribute may not be greater than :value.",
    "min_len"                  => "The :attribute must be at least :value.",
    ValidEmail::class          => "The :attribute format is invalid.",
    "alpha"                    => "The :attribute may only contain letters.",
    "only_alpha"               => "The :attribute may only contain letters.",
    "alpha_space"              => "The :attribute may only contain letters and spaces.",
    "only_alpha_space"         => "The :attribute may only contain letters and spaces.",
    "alpha_dash"               => "The :attribute may only contain letters, numbers, and dashes.",
    "only_alpha_dash"          => "The :attribute may only contain letters, numbers, and dashes.",
    "alpha_numeric"            => "The :attribute may only contain letters and numbers.",
    "only_alpha_numeric"       => "The :attribute may only contain letters and numbers.",
    "alpha_numeric_space"      => "The :attribute may only contain letters, numbers and spaces.",
    "only_alpha_numeric_space" => "The :attribute may only contain letters, numbers and spaces.",
    "alpha_numeric_dash"       => "The :attribute may only contain letters, numbers and dash.",
    "only_alpha_numeric_dash"  => "The :attribute may only contain letters, numbers and dash.",
    "numeric"                  => "The :attribute must be a number.",
    "integer"                  => "The :attribute must be an integer.",
    "equals"                   => "The :attribute not equal than :value.",
    "date"                     => "The :attribute format is invalid.",
    "groupdate"                => "The :attribute format is invalid.",
    "url"                      => "The :attribute format is invalid."

];