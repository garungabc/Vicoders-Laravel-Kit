<?php

namespace App\Validators;

use App\Validators\AbstractValidator;

class UserValidator extends AbstractValidator
{

    protected $rules = [
        'RULE_CREATE' => [
            'email'           => ['required', 'email'],
            'password'        => ['required', 'min:6', 'max:30'],
            'first_name'      => ['required', 'regex:/[a-z0-9\s]*/i', 'max:20'],
            'last_name'       => ['required', 'regex:/[a-z0-9\s]*/i', 'max:20'],
            'phone_area_code' => ['required', 'regex:/^\d+$/', 'max:5'],
            'phone_number'    => ['required', 'regex:/^\d+$/', 'max:15'],
        ],
    ];
}
