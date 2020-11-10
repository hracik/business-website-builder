<?php

namespace App\Validator\Constraints;

use App\Entity\CryptoCurrencyAccount;
use Merkeleon\PhpCryptocurrencyAddressValidation\Exception\CryptocurrencyValidatorNotFound;
use Merkeleon\PhpCryptocurrencyAddressValidation\Validation;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @Annotation
 */
class CryptoAddressValidator extends ConstraintValidator
{

	/**
	 * @param mixed      $cryptoCurrencyAccount
	 * @param Constraint $constraint
	 * @throws CryptocurrencyValidatorNotFound
	 */
	public function validate($cryptoCurrencyAccount, Constraint $constraint)
	{
		/** @var CryptoCurrencyAccount $cryptoCurrencyAccount */
		if (null !== $cryptoCurrencyAccount->getCurrency() && null !== $cryptoCurrencyAccount->getAddress()) {
			$validator = Validation::make($cryptoCurrencyAccount->getCurrency());
			if ($validator->validate($cryptoCurrencyAccount->getAddress()) === false) {
				$this->context->buildViolation($constraint->message)
					->setParameter('{{ currency }}', $cryptoCurrencyAccount->getCurrency())
					->atPath('address')
					->addViolation();
			}
		}
	}
}