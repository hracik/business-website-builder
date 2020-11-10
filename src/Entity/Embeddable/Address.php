<?php

namespace App\Entity\Embeddable;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as AppAssert;

/**
 * @AppAssert\PostalCode()
 * @ORM\Embeddable
 */
class Address
{

	/**
	 * @Assert\NotBlank
	 * @Assert\Length(max="255")
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $street;

	/**
	 * @Assert\NotBlank
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $postalCode;

	/**
	 * @Assert\NotBlank
	 * @Assert\Length(max="255")
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $city;

	/**
	 * @Assert\NotBlank
	 * @Assert\Length(min="2", max="2")
	 * @ORM\Column(type="string", length=2, nullable=true)
	 */
	protected $country;

	public function __toString()
	{
		return $this->getLabel();
	}

	public function getLabel(): string
	{
		$parts = [];
		if (null !== $this->getCity()) {
			$parts[] = $this->getCity();
		}
		if (null !== $this->getStreet()) {
			$parts[] = $this->getStreet();
		}
		if (null !== $this->getPostalCode()) {
			$parts[] = $this->getPostalCode();
		}
		if (null !== $this->getCountry()) {
			$parts[] = Countries::getName($this->getCountry());
		}

		return implode(', ', $parts);
	}

	public function getStreet(): ?string
	{
		return $this->street;
	}

	public function setStreet(?string $street): self
	{
		$this->street = $street;

		return $this;
	}

	public function getPostalCode(): ?string
	{
		return $this->postalCode;
	}

	public function setPostalCode(?string $postalCode): self
	{
		$this->postalCode = $postalCode;

		return $this;
	}

	public function getCity(): ?string
	{
		return $this->city;
	}

	public function setCity(?string $city): self
	{
		$this->city = $city;

		return $this;
	}

	public function getCountry(): ?string
	{
		return $this->country;
	}

	public function setCountry(?string $country): self
	{
		$this->country = $country;

		return $this;
	}

}