<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class AttachmentValidator.
 *
 * @package namespace App\Validators;
 */
class AttachmentValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
	        'source' => 'image'
        ],
        ValidatorInterface::RULE_UPDATE => [
	        //'source' => 'required|image'
        ],
    ];
}
