<?php

namespace App\Validators;

use App\Validators\AbstractValidator;

class ProductValidator extends AbstractValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE             => [
            'name'        => ['required'],
            'image'       => ['required'],
            'description' => ['required'],
            'price'       => ['required', 'numeric'],
        ],
        ValidatorInterface::RULE_UPDATE             => [
            'name'        => ['required'],
            'image'       => ['required'],
            'description' => ['required'],
            'price'       => ['required', 'numeric'],
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
