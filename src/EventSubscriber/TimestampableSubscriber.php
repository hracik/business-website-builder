<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Entity\Interfaces\TimestampableInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;

final class TimestampableSubscriber implements EventSubscriber
{
	/**
	 * @var EntityManagerInterface
	 */
	private $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	/**
	 * @return string[]
	 */
	public function getSubscribedEvents(): array
	{
		return [Events::loadClassMetadata];
	}

	/**
	 * @param LoadClassMetadataEventArgs $loadClassMetadataEventArgs
	 */
	public function loadClassMetadata(LoadClassMetadataEventArgs $loadClassMetadataEventArgs): void
	{
		$classMetadata = $loadClassMetadataEventArgs->getClassMetadata();
		if ($classMetadata->reflClass === null) {
			// Class has not yet been fully built, ignore this event
			return;
		}

		if (!is_a($classMetadata->reflClass->getName(), TimestampableInterface::class, true)) {
			return;
		}

		$classMetadata->addLifecycleCallback('updateTimestamps', Events::prePersist);
		$classMetadata->addLifecycleCallback('updateTimestamps', Events::preUpdate);
	}
}
