<?php

namespace App\Validators;

interface ValidatorInterface
{
	const RULE_CREATE             = 'RULE_CREATE';
	const RULE_UPDATE             = 'RULE_UPDATE';
	const RULE_LIST               = 'RULE_LIST';
	const CHANGE_STATUS_ALL_ITEMS = 'CHANGE_STATUS_ALL_ITEMS';
	const CHANGE_STATUS_ITEM      = 'CHANGE_STATUS_ITEM';
	
    public function isValid($data, $action);
}
