<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateUserCommand extends Command
{

	private $validator;
	private $entityManager;
	private $passwordEncoder;

	// the name of the command (the part after "bin/console")
	protected static $defaultName = 'app:create-user';

	public function __construct(ValidatorInterface $validator, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager)
	{
		parent::__construct();

		$this->validator = $validator;
		$this->passwordEncoder = $passwordEncoder;
		$this->entityManager = $entityManager;
	}

	protected function configure()
	{
		$this
			// the short description shown while running "php bin/console list"
			->setDescription('Creates a new user.')

			// the full command description shown when running the command with
			// the "--help" option
			->setHelp('This command allows you to create a user...')
		;
	}

	/**
	 * @param InputInterface  $input
	 * @param OutputInterface $output
	 * @return int
	 * @throws Exception
	 */
	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		// ... put here the code to run in your command
		$io = new SymfonyStyle($input, $output);
		$io->title('User Creator');
		$email = $io->askHidden('Choose the email',  Validation::createCallable(new NotBlank(), new Email()));
		$password = $io->askHidden('Choose the password',  Validation::createCallable(new NotBlank()));

		$user = new User();
		$user->setEmail($email);
		$user->setPassword($this->passwordEncoder->encodePassword($user, $password));

		// this method must return an integer number with the "exit status code"
		// of the command. You can also use these constants to make code more readable

		$violations = $this->validator->validate($user);
		if (0 === $violations->count()) {
			$this->entityManager->persist($user);
			$this->entityManager->flush();

			$io->success('User successfully generated!');

			// return this if there was no problem running the command
			// (it's equivalent to returning int(0))
			return Command::SUCCESS;
		}
		else {
			/** @var ConstraintViolationList $violations */
			$messages = [];
			foreach ($violations->getIterator() as $violation) {
				$messages[] = sprintf('Property: %s. Message: %s.', $violation->getPropertyPath(), $violation->getMessage());
			}
			$io->error($messages);
			$io->error('Something went wrong!');

			// or return this if some error happened during the execution
			// (it's equivalent to returning int(1))
			return Command::FAILURE;
		}
	}
}
