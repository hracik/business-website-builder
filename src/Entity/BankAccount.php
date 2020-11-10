<?php

namespace App\Entity;

use App\Entity\Interfaces\TimestampableInterface;
use App\Entity\Traits\Account;
use App\Repository\BankAccountRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BankAccountRepository::class)
 * @UniqueEntity(fields={"IBAN"})
 */
class BankAccount implements TimestampableInterface
{

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
    private $BIC;

    /**
     * @Assert\NotBlank
     * @Assert\Iban()
     * @ORM\Column(type="string", unique=true, length=255)
     */
    private $IBAN;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reference;

    /**
     * @ORM\Column(type="array")
     */
    private $currencies = [];

    /**
     * @ORM\ManyToOne(targetEntity=AccountProvider::class, inversedBy="bankAccounts")
     */
    private $provider;

    /**
     * @ORM\ManyToOne(targetEntity=Business::class, inversedBy="bankAccounts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $business;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBIC(): ?string
    {
        return $this->BIC;
    }

    public function setBIC(string $BIC): self
    {
        $this->BIC = $BIC;

        return $this;
    }

    public function getIBAN(): ?string
    {
        return $this->IBAN;
    }

    public function setIBAN(string $IBAN): self
    {
        $this->IBAN = $IBAN;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getCurrencies(): ?array
    {
        return $this->currencies;
    }

    public function setCurrencies(array $currencies): self
    {
        $this->currencies = $currencies;

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
