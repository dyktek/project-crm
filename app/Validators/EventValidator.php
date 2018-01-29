<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class EventValidator.
 *
 * @package namespace App\Validators;
 */
class EventValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
        	'title' => 'required',
	        'user_id' => 'required|exists:users,id',
	        'start_date' => 'required|date_format:Y-m-d H:i:s',
	        'end_date' => 'required|date_format:Y-m-d H:i:s'
        ],
        ValidatorInterface::RULE_UPDATE => [],
    ];
}
