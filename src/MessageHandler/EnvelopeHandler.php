<?php

namespace App\MessageHandler;

use App\Message\Envelope;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Mime\Address;

class EnvelopeHandler implements MessageHandlerInterface
{
	private $mailer;
	private $settings;

	public function __construct(MailerInterface $mailer, array $settings)
	{
		$this->mailer = $mailer;
		$this->settings = $settings;
	}

	/**
	 * @param Envelope $envelope
	 * @throws TransportExceptionInterface
	 */
	public function __invoke(Envelope $envelope)
	{
		$from = new Address($envelope->getEmail());
		$to = new Address($this->settings['mailerRecipient']);

		$message = (new TemplatedEmail())
			->from($from)
			->to($to)
			->subject('New message')
			->htmlTemplate('email/message.html.twig')
			->context(['message' => $envelope->getMessage()])
		;

		$this->mailer->send($message);
	}
}