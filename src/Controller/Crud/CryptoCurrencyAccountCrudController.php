<?php

namespace App\Controller\Crud;

use App\Entity\CryptoCurrencyAccount;
use App\Service\Loader;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CryptoCurrencyAccountCrudController extends AbstractCrudController
{

	private $loader;

	public function __construct(Loader $loader)
	{
		$this->loader = $loader;
	}

	public static function getEntityFqcn(): string
    {
        return CryptoCurrencyAccount::class;
    }

	public function createEntity(string $entityFqcn): CryptoCurrencyAccount
	{
		$business = $this->loader->getBusiness();

		$cryptoCurrencyAccount = new CryptoCurrencyAccount();
		$cryptoCurrencyAccount->setBusiness($business);

		return $cryptoCurrencyAccount;
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
		    ->setEntityLabelInSingular('label.crypto_currency_account')
		    ->setEntityLabelInPlural('label.crypto_currency_accounts')
		    ;
    }

    public function configureFields(string $pageName): iterable
    {
	    $id = IntegerField::new('id', 'label.id');
	    $provider = AssociationField::new('provider', 'label.account_provider');
	    $note = TextareaField::new('note', 'label.note');
	    $internalNote = TextareaField::new('internalNote', 'label.internal_note');
	    $active = BooleanField::new('active', 'label.active');
	    $public = BooleanField::new('public', 'label.public');
	    $createdAt = DateTimeField::new('createdAt', 'label.created_at');
	    $updatedAt = DateTimeField::new('updatedAt', 'label.updated_at');

	    //custom fields
	    $currency = ChoiceField::new('currency', 'label.currency')->setChoices(CryptoCurrencyAccount::getCurrencyChoices());
	    $address = TextField::new('address', 'label.address');

	    if (Crud::PAGE_INDEX === $pageName) {
		    return [$currency, $address, $active, $public, $createdAt, $updatedAt];
	    } elseif (Crud::PAGE_DETAIL === $pageName) {
		    return [$id, $currency, $address,  $provider, $active, $public, $note, $internalNote, $createdAt, $updatedAt];
	    } elseif (Crud::PAGE_NEW === $pageName) {
		    return [$currency, $address,  $provider, $active, $public, $note, $internalNote];
	    } elseif (Crud::PAGE_EDIT === $pageName) {
		    return [$currency, $address,  $provider, $active, $public, $note, $internalNote];
	    }
    }
}
