<?php

namespace App\Form;

use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactFormType extends AbstractType
{

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('email', EmailType::class, [
				'label' => 'label.email',
				'constraints' => [
					new NotBlank(), new Email(),
				],
			])
			->add('message', TextareaType::class, [
				'label' => 'label.message',
				'constraints' => [
					new NotBlank(),
				],
			])
			->add('captcha', Recaptcha3Type::class, [
				'constraints' => new Recaptcha3(),
			])
		;
	}
}
