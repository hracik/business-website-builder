<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CryptoAddress extends Constraint
{
	public $message = 'validators.crypto_currency_account.invalid_address';

	//BTC, DASH, BCH, ZEC, LTC
	public function getTargets()
	{
		// so we can access multiple properties
		return self::CLASS_CONSTRAINT;
	}
}