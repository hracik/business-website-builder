<?php

namespace App\EventSubscriber;

use App\Entity\Business;
use App\Service\Loader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class KernelSubscriber implements EventSubscriberInterface
{

	private $loader;
	private $manager;

	public function __construct(Loader $loader, EntityManagerInterface $manager)
	{
		$this->loader = $loader;
		$this->manager = $manager;
	}


	//now there are 4 types of scenarios:
	//todo public page of restaurant is requested on custom domain with no URL parameter => restaurant is always set
	//public page of restaurant is requested on project domain with parameters in URL address => restaurant is always set
	//ROLE_RESTAURANT_WORKER is logged in manager namespace => restaurant is always set
	//ROLE_RESTAURANT_MANAGER is logged in manager namespace => restaurant is not always set, there are few exceptions

	public static function getSubscribedEvents(): array
	{
		return [
			KernelEvents::REQUEST => [
				['setBusiness'],
			],
		];
	}

	/**
	 * @param RequestEvent $event
	 * @return null|object|void
	 */
	public function setBusiness(RequestEvent $event)
	{
		if (!$event->isMasterRequest()) {
			return;
		}

		$business = $this->manager->getRepository(Business::class)->findOne();
		if (null !== $business) {
			$this->loader->setBusiness($business);
		}
	}

}