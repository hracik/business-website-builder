<?php

namespace App\Entity;

use App\Entity\Embeddable\Address;
use App\Entity\Embeddable\PhoneNumber;
use App\Entity\Interfaces\TimestampableInterface;
use App\Entity\Traits\TimestampableTrait;
use App\Repository\BusinessRepository;
use DateTime;
use DateTimeInterface;
use Ddeboer\VatinBundle\Validator\Constraints\Vatin;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=BusinessRepository::class)
 * @Vich\Uploadable
 */
class Business implements TimestampableInterface
{

	use TimestampableTrait;

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
	private $name;

	/**
	 * @Assert\Valid()
	 * @ORM\Embedded(class="App\Entity\Embeddable\Address", columnPrefix="address_")
	 */
	private $address;

	/**
	 * @Assert\Valid()
	 * @ORM\Embedded(class="App\Entity\Embeddable\PhoneNumber", columnPrefix="phone_")
	 */
	private $phoneNumber;

	/**
	 * @Assert\NotBlank
	 * @ORM\Column(type="date")
	 */
	private $incorporatedAt;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $description;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $registryURL;

	/**
	 * @Assert\Email
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $email;

	/**
	 * @Vatin(message="validators.VAT.invalid")
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $VAT;

	/**
	 * @Assert\NotBlank
	 * @ORM\Column(type="string", length=255)
	 */
	private $identificationNumber;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $logo;

	/**
	 * @Assert\Image(detectCorrupted=true)
	 * @Vich\UploadableField(mapping="business", fileNameProperty="logo")
	 * @var File
	 */
	private $logoFile;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $icon;

	/**
	 * @Assert\Image(allowLandscape=false, allowPortrait=false, detectCorrupted=true)
	 * @Vich\UploadableField(mapping="business", fileNameProperty="icon")
	 * @var File
	 */
	private $iconFile;

	/**
	 * @ORM\OneToMany(targetEntity=BankAccount::class, mappedBy="business", cascade={"remove"})
	 */
	private $bankAccounts;

	/**
	 * @ORM\OneToMany(targetEntity=CryptoCurrencyAccount::class, mappedBy="business", cascade={"remove"})
	 */
	private $cryptoCurrencyAccounts;

	/**
	 * @ORM\OneToMany(targetEntity=ServiceAccount::class, mappedBy="business", cascade={"remove"})
	 */
	private $serviceAccounts;

	public function __construct()
	{
		$this->address = new Address();
		$this->phoneNumber = new PhoneNumber();
		$this->bankAccounts = new ArrayCollection();
		$this->cryptoCurrencyAccounts = new ArrayCollection();
		$this->serviceAccounts = new ArrayCollection();
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getName(): ?string
	{
		return $this->name;
	}

	public function setName(?string $name): self
	{
		$this->name = $name;

		return $this;
	}

	public function getIncorporatedAt(): ?DateTimeInterface
	{
		return $this->incorporatedAt;
	}

	public function setIncorporatedAt(?DateTimeInterface $incorporatedAt): self
	{
		$this->incorporatedAt = $incorporatedAt;

		return $this;
	}

	public function getDescription(): ?string
	{
		return $this->description;
	}

	public function setDescription(?string $description): self
	{
		$this->description = $description;

		return $this;
	}

	public function getRegistryURL(): ?string
	{
		return $this->registryURL;
	}

	public function setRegistryURL(?string $registryURL): self
	{
		$this->registryURL = $registryURL;

		return $this;
	}

	public function getEmail(): ?string
	{
		return $this->email;
	}

	public function setEmail(?string $email): self
	{
		$this->email = $email;

		return $this;
	}

	public function getVAT(): ?string
	{
		return $this->VAT;
	}

	public function setVAT(?string $VAT): self
	{
		$this->VAT = $VAT;

		return $this;
	}

	public function getIdentificationNumber(): ?string
	{
		return $this->identificationNumber;
	}

	public function setIdentificationNumber(?string $identificationNumber): self
	{
		$this->identificationNumber = $identificationNumber;

		return $this;
	}

	public function getLogo(): ?string
	{
		return $this->logo;
	}

	public function setLogo(?string $logo): self
	{
		$this->logo = $logo;

		return $this;
	}

	public function getIcon(): ?string
	{
		return $this->icon;
	}

	public function setIcon(?string $icon): self
	{
		$this->icon = $icon;

		return $this;
	}

	public function setLogoFile(File $logo = null)
	{
		$this->logoFile = $logo;

		if ($logo) {
			$this->updatedAt = new DateTime('now');
		}
	}

	public function getLogoFile()
	{
		return $this->logoFile;
	}

	public function setIconFile(File $icon = null)
	{
		$this->iconFile = $icon;

		if ($icon) {
			$this->updatedAt = new DateTime('now');
		}
	}

	public function getIconFile()
	{
		return $this->iconFile;
	}

	public function getAddress(): Address
	{
		return $this->address;
	}

	public function setAddress(Address $address): self
	{
		$this->address = $address;

		return $this;
	}

	public function getPhoneNumber(): PhoneNumber
	{
		return $this->phoneNumber;
	}

	public function setPhoneNumber(PhoneNumber $phoneNumber): self
	{
		$this->phoneNumber = $phoneNumber;

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
			$bankAccount->setBusiness($this);
		}

		return $this;
	}

	public function removeBankAccount(BankAccount $bankAccount): self
	{
		if ($this->bankAccounts->removeElement($bankAccount)) {
			// set the owning side to null (unless already changed)
			if ($bankAccount->getBusiness() === $this) {
				$bankAccount->setBusiness(null);
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
			$cryptoCurrencyAccount->setBusiness($this);
		}

		return $this;
	}

	public function removeCryptoCurrencyAccount(CryptoCurrencyAccount $cryptoCurrencyAccount): self
	{
		if ($this->cryptoCurrencyAccounts->removeElement($cryptoCurrencyAccount)) {
			// set the owning side to null (unless already changed)
			if ($cryptoCurrencyAccount->getBusiness() === $this) {
				$cryptoCurrencyAccount->setBusiness(null);
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
			$serviceAccount->setBusiness($this);
		}

		return $this;
	}

	public function removeServiceAccount(ServiceAccount $serviceAccount): self
	{
		if ($this->serviceAccounts->removeElement($serviceAccount)) {
			// set the owning side to null (unless already changed)
			if ($serviceAccount->getBusiness() === $this) {
				$serviceAccount->setBusiness(null);
			}
		}

		return $this;
	}

}
