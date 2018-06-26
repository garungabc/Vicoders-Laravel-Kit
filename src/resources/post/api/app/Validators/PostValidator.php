<?php

namespace App\Validators;

use App\Validators\AbstractValidator;

class PostValidator extends AbstractValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE             => [
            'title'       => ['required'],
            'image'       => ['required'],
            'description' => ['required'],
            'content'     => ['required'],
        ],
        ValidatorInterface::RULE_UPDATE             => [
            'title'       => ['required'],
            'image'       => ['required'],
            'description' => ['required'],
            'content'     => ['required'],
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
