<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class NoteValidator.
 *
 * @package namespace App\Validators;
 */
class NoteValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
	        'note' => 'required',
	        'user_id' => 'required|exists:users,id',
	        'event_id' => 'required|exists:events,id'
        ],
        ValidatorInterface::RULE_UPDATE => [
	        'note' => 'required',
	        'user_id' => 'required|exists:users,id',
	        'event_id' => 'required|exists:events,id'
        ],
    ];
}
