<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class E164Number extends Constraint
{
	public $invalid = 'validators.phone_number.invalid';
	public $unauthorized = 'validators.phone_number.unauthorized';

	public function getTargets()
	{
		// so we can access multiple properties
		return self::CLASS_CONSTRAINT;
	}
}