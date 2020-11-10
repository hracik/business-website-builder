<?php

namespace App\Validator\Constraints;

use App\Entity\Embeddable\PhoneNumber;
use LogicException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\HttpFoundation\Response;
use Twilio\Exceptions\RestException;
use Twilio\Rest\Client;

/**
 * @Annotation
 */
class E164NumberValidator extends ConstraintValidator
{
	private $twilio;

	public function __construct(Client $twilio)
	{
		$this->twilio = $twilio;
	}

	public function validate($phoneNumber, Constraint $constraint)
	{
		/** @var PhoneNumber $phoneNumber */
		if ($phoneNumber->getNumber() !== null && $phoneNumber->getCountry() !== null) {
			try {
				$number = $this->twilio->lookups
					->phoneNumbers($phoneNumber->getNumber())
					->fetch(['countryCode' => $phoneNumber->getCountry()]);

				//set new number in unified format
				$phoneNumber->setNumber($number->phoneNumber);
				//in case user use +421, 00421 as country code, but select another country .. we reset countryCode
				$phoneNumber->setCountry($number->countryCode);
			} catch (RestException $e) {
				if ($e->getStatusCode() === Response::HTTP_NOT_FOUND) {
					$this->context
						->buildViolation($constraint->invalid)
						->atPath('number')
						->addViolation();
				}
				elseif ($e->getStatusCode() === Response::HTTP_UNAUTHORIZED) {
					$this->context
						->buildViolation($constraint->unauthorized)
						->atPath('number')
						->addViolation();
				}
				else {
					throw new LogicException($e->getMessage(), $e->getStatusCode());
				}
			}
		}
	}
}