<?php

namespace App\Form\Type;

use App\Entity\Embeddable\PhoneNumber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PhoneNumberType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number', TextType::class, [
	            'label' => 'label.phone_number_group.number',
	            'required' => false,
            ])
	        ->add('country', CountryType::class, [
		        'label' => 'label.phone_number_group.country',
		        'required' => false,
	        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PhoneNumber::class,
        ]);
    }
}
