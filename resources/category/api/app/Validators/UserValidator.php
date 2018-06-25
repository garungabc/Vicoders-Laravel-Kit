<?php

namespace App\Validators;

use App\Validators\AbstractValidator;

class CategoryValidator extends AbstractValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE             => [
            'name' => ['required'],
        ],
        ValidatorInterface::RULE_UPDATE             => [
            'name' => ['required'],
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
