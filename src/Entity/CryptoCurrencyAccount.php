<?php

namespace App\Entity;

use App\Entity\Interfaces\TimestampableInterface;
use App\Entity\Traits\Account;
use App\Repository\CryptoCurrencyAccountRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as AppAssert;

/**
 * @AppAssert\CryptoAddress
 * @ORM\Entity(repositoryClass=CryptoCurrencyAccountRepository::class)
 * @UniqueEntity(fields={"address"})
 */
class CryptoCurrencyAccount implements TimestampableInterface
{

	const BTC = 'BTC';
	const LTC = 'LTC';
	const BCH = 'BCH';

	public static function getCurrencyChoices()
	{
		return [
			'Bitcoin - BTC' => self::BTC,
			'Litecoin - LTC' => self::LTC,
			'BitcoinCash - BCH' => self::BCH,
		];
	}

	use Account;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private $currency;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", unique=true, length=255)
     */
    private $address;

    /**
     * @ORM\ManyToOne(targetEntity=AccountProvider::class, inversedBy="cryptoCurrencyAccounts")
     */
    private $provider;

    /**
     * @ORM\ManyToOne(targetEntity=Business::class, inversedBy="cryptoCurrencyAccounts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $business;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getProvider(): ?AccountProvider
    {
        return $this->provider;
    }

    public function setProvider(?AccountProvider $provider): self
    {
        $this->provider = $provider;

        return $this;
    }

    public function getBusiness(): ?Business
    {
        return $this->business;
    }

    public function setBusiness(?Business $business): self
    {
        $this->business = $business;

        return $this;
    }

}
