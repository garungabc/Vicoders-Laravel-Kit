<?php

namespace App\Validators;

use App\Validators\AbstractValidator;

class TestimonialValidator extends AbstractValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE             => [
            'first_name' => ['required'],
            'last_name'  => ['required'],
            'image'      => ['required'],
            'content'    => ['required'],
        ],
        ValidatorInterface::RULE_UPDATE             => [
            'first_name' => ['required'],
            'last_name'  => ['required'],
            'image'      => ['required'],
            'content'    => ['required'],
        ],
        ValidatorInterface::CHANGE_STATUS_ALL_ITEMS => [
            'item_ids' => ['required'],
            'status'   => ['required'],
        ],
        ValidatorInterface::CHANGE_STATUS_ITEM      => [
            'status' => ['required'],
        ],
    ];
}
