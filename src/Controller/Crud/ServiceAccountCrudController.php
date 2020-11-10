<?php

namespace App\Controller\Crud;

use App\Entity\ServiceAccount;
use App\Form\Type\CurrencyType;
use App\Service\Loader;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ServiceAccountCrudController extends AbstractCrudController
{

	private $loader;

	public function __construct(Loader $loader)
	{
		$this->loader = $loader;
	}

	public static function getEntityFqcn(): string
    {
        return ServiceAccount::class;
    }

	public function createEntity(string $entityFqcn): ServiceAccount
	{
		$business = $this->loader->getBusiness();

		$serviceAccount = new ServiceAccount();
		$serviceAccount->setBusiness($business);

		return $serviceAccount;
	}

	public function configureActions(Actions $actions): Actions
	{
		if (null === $this->loader->getBusiness()) {
			$actions->disable(Action::INDEX, Action::DETAIL, Action::NEW,  Action::EDIT, Action::DELETE);
		}
		$actions->add(Crud::PAGE_INDEX, Action::DETAIL);
		return $actions;
	}

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('label.service_account')
	        ->setEntityLabelInPlural('label.service_accounts')
	    ;
    }

    public function configureFields(string $pageName): iterable
    {
	    $id = IntegerField::new('id', 'label.id');
	    $provider = AssociationField::new('provider', 'label.account_provider')
		    ->setFormTypeOption('required', true)
	    ;
	    $note = TextareaField::new('note', 'label.note');
	    $internalNote = TextareaField::new('internalNote', 'label.internal_note');
	    $active = BooleanField::new('active', 'label.active');
	    $public = BooleanField::new('public', 'label.public');
	    $createdAt = DateTimeField::new('createdAt', 'label.created_at');
	    $updatedAt = DateTimeField::new('updatedAt', 'label.updated_at');

	    //custom fields
	    $identifier = TextField::new('identifier', 'label.identifier');
	    $currencies = CollectionField::new('currencies', 'label.currencies')->setEntryType(CurrencyType::class);

	    if (Crud::PAGE_INDEX === $pageName) {
		    return [$identifier, $currencies,  $provider, $active, $public, $createdAt, $updatedAt];
	    } elseif (Crud::PAGE_DETAIL === $pageName) {
		    return [$id, $identifier, $currencies, $provider, $active, $public, $note, $internalNote, $createdAt, $updatedAt];
	    } elseif (Crud::PAGE_NEW === $pageName) {
		    return [$identifier, $currencies, $provider, $active, $public, $note, $internalNote];
	    } elseif (Crud::PAGE_EDIT === $pageName) {
		    return [$identifier, $currencies, $provider, $active, $public, $note, $internalNote];
	    }
    }
}
