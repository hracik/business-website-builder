<?php

namespace App\Entity\Traits;

use DateTime;
use DateTimeInterface;
use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;
use LogicException;

trait TimestampableTrait
{
	/**
	 * @var DateTime
	 * @ORM\Column(type="datetime")
	 */
	protected $createdAt;

	/**
	 * @var DateTime
	 * @ORM\Column(type="datetime")
	 */
	protected $updatedAt;

	public function getCreatedAt(): DateTimeInterface
	{
		return $this->createdAt;
	}

	public function getUpdatedAt(): DateTimeInterface
	{
		return $this->updatedAt;
	}

	public function setCreatedAt(DateTimeInterface $createdAt): void
	{
		$this->createdAt = $createdAt;
	}

	public function setUpdatedAt(DateTimeInterface $updatedAt): void
	{
		$this->updatedAt = $updatedAt;
	}

	/**
	 * Called in TimestampableSubscriber
	 * Updates createdAt and updatedAt timestamps.
	 */
	public function updateTimestamps(): void
	{
		// Create a datetime with microseconds
		$dateTime = DateTime::createFromFormat('U.u', sprintf('%.6F', microtime(true)));

		if ($dateTime === false) {
			throw new LogicException();
		}

		$dateTime->setTimezone(new DateTimeZone(date_default_timezone_get()));

		if ($this->createdAt === null) {
			$this->createdAt = $dateTime;
		}

		$this->updatedAt = $dateTime;
	}

}
