<?php

namespace App\Controller\Crud;

use App\Entity\BankAccount;
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

class BankAccountCrudController extends AbstractCrudController
{
	private $loader;

	public function __construct(Loader $loader)
	{
		$this->loader = $loader;
	}

	public static function getEntityFqcn(): string
    {
        return BankAccount::class;
    }

	public function createEntity(string $entityFqcn): BankAccount
	{
		$business = $this->loader->getBusiness();

		$bankAccount = new BankAccount();
		$bankAccount->setBusiness($business);
		return $bankAccount;
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
		    ->setEntityLabelInSingular('label.bank_account')
		    ->setEntityLabelInPlural('label.bank_accounts')
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
	    $IBAN = TextField::new('IBAN', 'label.IBAN');
	    $BIC = TextField::new('BIC', 'label.BIC');
	    $reference = TextField::new('reference', 'label.reference');
	    $currencies = CollectionField::new('currencies', 'label.currencies')->setEntryType(CurrencyType::class);

	    if (Crud::PAGE_INDEX === $pageName) {
            return [$IBAN, $BIC, $currencies, $active, $public, $createdAt, $updatedAt];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
		    return [$id, $IBAN, $BIC, $currencies, $reference,  $provider, $active, $public, $note, $internalNote, $createdAt, $updatedAt];
	    } elseif (Crud::PAGE_NEW === $pageName) {
	        return [$IBAN, $BIC, $currencies, $reference, $provider, $active, $public, $note, $internalNote];
        } elseif (Crud::PAGE_EDIT === $pageName) {
	        return [$IBAN, $BIC, $currencies, $reference, $provider, $active, $public, $note, $internalNote];
        }
    }
}
