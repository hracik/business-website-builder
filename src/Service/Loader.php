<?php

namespace App\Service;

use App\Entity\Business;

class Loader
{

	private ?Business $business = null;

	public function setBusiness(Business $business)
	{
		$this->business = $business;
	}

	public function getBusiness(): ?Business
	{
		return $this->business;
	}
}
