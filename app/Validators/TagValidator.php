<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class TagValidator.
 *
 * @package namespace App\Validators;
 */
class TagValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
	        'name' => 'required',
	        'event_id' => 'required|exists:events,id'
        ],
        ValidatorInterface::RULE_UPDATE => [
	        'name' => 'required',
	        'event_id' => 'required|exists:events,id'
        ],
    ];
}
