<?php

namespace App\Validator\Constraints;

use App\Entity\Embeddable\Address;
use Sirprize\PostalCodeValidator\ValidationException;
use Sirprize\PostalCodeValidator\Validator;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @Annotation
 */
class PostalCodeValidator extends ConstraintValidator
{

	public function validate($address, Constraint $constraint)
	{
		/** @var Address $address */
		if (null !== $address->getCountry() && null !== $address->getPostalCode()) {
			$validator = new Validator();
			try {
				if (!$validator->isValid($address->getCountry(), $address->getPostalCode())) {
					$formats = $validator->getFormats($address->getCountry());
					$this->context->buildViolation($constraint->invalidPostalCode)
						->atPath('postalCode')
						->setParameter('{{ country }}', Countries::getName( $address->getCountry()))
						->setParameter('{{ format }}', implode(',', $formats))
						->addViolation();
				}
			}
			catch (ValidationException $e) {
				//country is not supported, so validation is not performed..
			}
		}

	}
}