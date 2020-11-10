<?php

namespace App\Entity;

use App\Entity\Interfaces\TimestampableInterface;
use App\Entity\Traits\Account;
use App\Repository\ServiceAccountRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ServiceAccountRepository::class)
 * @ORM\Table(uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"identifier", "provider_id"}),
 * })
 * @UniqueEntity(fields={"identifier", "provider"})
 */
class ServiceAccount implements TimestampableInterface
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
    private $identifier;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="array")
     */
    private $currencies = [];

    /**
     * @Assert\NotBlank
     * @ORM\ManyToOne(targetEntity=AccountProvider::class, inversedBy="serviceAccounts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $provider;

    /**
     * @ORM\ManyToOne(targetEntity=Business::class, inversedBy="serviceAccounts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $business;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): self
    {
        $this->identifier = $identifier;

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
