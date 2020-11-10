<?php

namespace App\Message;

class Envelope
{

	private $email;
	private $message;

	public function __construct(string $email, string $message)
	{
		$this->email = $email;
		$this->message = $message;
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	public function getMessage(): string
	{
		return $this->message;
	}

}