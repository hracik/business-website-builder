<?php

namespace App\Form\Type;

use App\Entity\Embeddable\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{

	public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
	        ->add('street', TextType::class, [
	        	'label' => 'label.address_group.street',
	        ])
	        ->add('city', TextType::class, [
		        'label' => 'label.address_group.city',
	        ])
	        ->add('postalCode', TextType::class, [
		        'label' => 'label.address_group.postal_code',
	        ])
	        ->add('country', CountryType::class, [
		        'label' => 'label.address_group.country',
	        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
	    $resolver->setDefaults([
		    'data_class' => Address::class,
	    ]);
    }
}
