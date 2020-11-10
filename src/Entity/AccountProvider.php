<?php

namespace App\Entity;

use App\Entity\Interfaces\TimestampableInterface;
use App\Entity\Traits\TimestampableTrait;
use App\Repository\AccountProviderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AccountProviderRepository::class)
 */
class AccountProvider implements TimestampableInterface
{

	use TimestampableTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @ORM\OneToMany(targetEntity=BankAccount::class, mappedBy="provider")
     */
    private $bankAccounts;

    /**
     * @ORM\OneToMany(targetEntity=CryptoCurrencyAccount::class, mappedBy="provider")
     */
    private $cryptoCurrencyAccounts;

    /**
     * @ORM\OneToMany(targetEntity=ServiceAccount::class, mappedBy="provider")
     */
    private $serviceAccounts;

    public function __construct()
    {
        $this->bankAccounts = new ArrayCollection();
        $this->cryptoCurrencyAccounts = new ArrayCollection();
        $this->serviceAccounts = new ArrayCollection();
    }

    public function __toString(): string
    {
    	return (string)$this->getName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return Collection|BankAccount[]
     */
    public function getBankAccounts(): Collection
    {
        return $this->bankAccounts;
    }

    public function addBankAccount(BankAccount $bankAccount): self
    {
        if (!$this->bankAccounts->contains($bankAccount)) {
            $this->bankAccounts[] = $bankAccount;
            $bankAccount->setProvider($this);
        }

        return $this;
    }

    public function removeBankAccount(BankAccount $bankAccount): self
    {
        if ($this->bankAccounts->removeElement($bankAccount)) {
            // set the owning side to null (unless already changed)
            if ($bankAccount->getProvider() === $this) {
                $bankAccount->setProvider(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CryptoCurrencyAccount[]
     */
    public function getCryptoCurrencyAccounts(): Collection
    {
        return $this->cryptoCurrencyAccounts;
    }

    public function addCryptoCurrencyAccount(CryptoCurrencyAccount $cryptoCurrencyAccount): self
    {
        if (!$this->cryptoCurrencyAccounts->contains($cryptoCurrencyAccount)) {
            $this->cryptoCurrencyAccounts[] = $cryptoCurrencyAccount;
            $cryptoCurrencyAccount->setProvider($this);
        }

        return $this;
    }

    public function removeCryptoCurrencyAccount(CryptoCurrencyAccount $cryptoCurrencyAccount): self
    {
        if ($this->cryptoCurrencyAccounts->removeElement($cryptoCurrencyAccount)) {
            // set the owning side to null (unless already changed)
            if ($cryptoCurrencyAccount->getProvider() === $this) {
                $cryptoCurrencyAccount->setProvider(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ServiceAccount[]
     */
    public function getServiceAccounts(): Collection
    {
        return $this->serviceAccounts;
    }

    public function addServiceAccount(ServiceAccount $serviceAccount): self
    {
        if (!$this->serviceAccounts->contains($serviceAccount)) {
            $this->serviceAccounts[] = $serviceAccount;
            $serviceAccount->setProvider($this);
        }

        return $this;
    }

    public function removeServiceAccount(ServiceAccount $serviceAccount): self
    {
        if ($this->serviceAccounts->removeElement($serviceAccount)) {
            // set the owning side to null (unless already changed)
            if ($serviceAccount->getProvider() === $this) {
                $serviceAccount->setProvider(null);
            }
        }

        return $this;
    }

}
