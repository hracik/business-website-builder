<?php

namespace App\Form\Type;

use Hracik\CurrencyList\CurrencyList;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\ChoiceList\Loader\IntlCallbackChoiceLoader;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CurrencyType extends AbstractType
{

	/**
	 * {@inheritdoc}
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'choice_loader' => function (Options $options) {
				$choiceTranslationLocale = $options['choice_translation_locale'];

				return ChoiceList::loader($this, new IntlCallbackChoiceLoader(function () use ($choiceTranslationLocale) {
					return array_flip(CurrencyList::get());
				}), $choiceTranslationLocale);
			},
			'choice_label' => function($choice, $value) {
				return sprintf('%s - %s', $choice, $value);
			},
			'choice_translation_domain' => false,
			'choice_translation_locale' => null,
		]);

		$resolver->setAllowedTypes('choice_translation_locale', ['null', 'string']);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getParent()
	{
		return ChoiceType::class;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getBlockPrefix()
	{
		return 'currency';
	}
}
