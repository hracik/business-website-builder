<?php

namespace App\Entity\Embeddable;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as AppAssert;

/**
 * @AppAssert\E164Number(groups={"E164"})
 * @Assert\GroupSequence({"PhoneNumber", "E164"})
 * @ORM\Embeddable()
 */
class PhoneNumber
{

	/**
	 * @Assert\Length(max="16")
	 * @ORM\Column(type="string", length=16, nullable=true)
	 */
	protected $number;

	/**
	 * @Assert\Length(max="2")
	 * @ORM\Column(type="string", length=2, nullable=true)
	 */
	protected $country;

	public function __toString()
	{
		return $this->getLabel();
	}

	public function getLabel(): string
	{
		return null === $this->number ? '' : $this->number;
	}

	public function setNumber(?string $number)
	{
		$this->number = $number;

		return $this;
	}

	public function getNumber(): ?string
	{
		return $this->number;
	}

	public function setCountry(?string $country)
	{
		$this->country = $country;

		return $this;
	}

	public function getCountry(): ?string
	{
		return $this->country;
	}

}