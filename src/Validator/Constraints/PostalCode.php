<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class PostalCode extends Constraint
{
	public $invalidPostalCode = 'validators.address_postal_code.invalid';

	public function getTargets()
	{
		// so we can access multiple properties
		return self::CLASS_CONSTRAINT;
	}
}