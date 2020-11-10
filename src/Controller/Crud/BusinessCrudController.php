<?php

namespace App\Controller\Crud;

use App\Entity\Business;
use App\Form\Type\AddressType;
use App\Form\Type\PhoneNumberType;
use App\Service\Loader;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class BusinessCrudController extends AbstractCrudController
{

	private $loader;

	public function __construct(Loader $loader)
	{
		$this->loader = $loader;
	}

	public static function getEntityFqcn(): string
    {
        return Business::class;
    }

	public function configureActions(Actions $actions): Actions
	{
		$actions
			->add(Crud::PAGE_INDEX, Action::DETAIL)
			->remove(Crud::PAGE_NEW,Action::SAVE_AND_ADD_ANOTHER)
		;

		$business = $this->loader->getBusiness();
		if (null !== $business) {
			$actions->disable(Action::NEW);
		}

		return $actions;
	}

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('label.business')
	        ->setEntityLabelInPlural('label.business')
	    ;
    }

    public function configureFields(string $pageName): iterable
    {
	    $id = IntegerField::new('id', 'label.id');
	    $name = TextField::new('name', 'label.name');
	    $description = TextEditorField::new('description', 'label.description');
	    $incorporatedAt = DateField::new('incorporatedAt', 'label.incorporated_at');
	    $identificationNumber = TextField::new('identificationNumber', 'label.identification_number');
	    $VAT = TextField::new('VAT', 'label.VAT');
	    $address = Field::new('address', 'label.address')->setFormType(AddressType::class);
	    $phoneNumber = Field::new('phoneNumber', 'label.phone_number')->setFormType(PhoneNumberType::class);

	    $logoFile = ImageField::new('logoFile', 'label.logo')->setFormType(VichImageType::class);
	    $logo = Field::new('logo','label.logo')
		    ->setTemplatePath('field/vich_uploader_image.html.twig')
		    ->setCustomOption('property', 'logoFile')
		    ->setCustomOption('imagine_filter', 'easyadmin')
	    ;
	    $iconFile = ImageField::new('iconFile', 'label.icon')->setFormType(VichImageType::class);
	    $icon = Field::new('icon','label.icon')
		    ->setTemplatePath('field/vich_uploader_image.html.twig')
		    ->setCustomOption('property', 'iconFile')
		    ->setCustomOption('imagine_filter', 'easyadmin')
	    ;

	    $email = EmailField::new('email', 'label.email');
	    $registryURL = UrlField::new('registryURL','label.registry_URL');
	    $createdAt = DateTimeField::new('createdAt', 'label.created_at');
        $updatedAt = DateTimeField::new('updatedAt', 'label.updated_at');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$name, $description, $identificationNumber, $VAT, $incorporatedAt, $logo, $icon];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
	        return [$id, $createdAt, $updatedAt, $name, $description, $address, $phoneNumber, $identificationNumber, $VAT, $incorporatedAt, $registryURL, $email, $logo, $icon];
        } elseif (Crud::PAGE_NEW === $pageName) {
	        return [$name, $description,  $address, $phoneNumber, $identificationNumber, $VAT, $incorporatedAt, $registryURL, $email, $logoFile, $iconFile];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$name, $description, $address, $phoneNumber, $identificationNumber, $VAT, $incorporatedAt, $registryURL, $email, $logoFile, $iconFile];
        }
    }
}
