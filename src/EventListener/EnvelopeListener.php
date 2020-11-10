<?php

namespace App\EventListener;

use App\Entity\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

class EnvelopeListener
{
	private $bus;

	public function __construct(MessageBusInterface $bus)
	{
		$this->bus = $bus;
	}

	public function postPersist(Envelope $envelope)
	{
		//send email when new Envelope is created
		$this->bus->dispatch(new \App\Message\Envelope($envelope->getEmail(), $envelope->getMessage()));
	}
}