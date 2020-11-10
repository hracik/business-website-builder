<?php

namespace App\Controller\Crud;

use App\Entity\AccountProvider;
use App\Service\Loader;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class AccountProviderCrudController extends AbstractCrudController
{
	private $loader;

	public function __construct(Loader $loader)
	{
		$this->loader = $loader;
	}

    public static function getEntityFqcn(): string
    {
        return AccountProvider::class;
    }

	public function configureActions(Actions $actions): Actions
	{
		if (null === $this->loader->getBusiness()) {
			$actions->disable([Action::NEW, Action::INDEX, Action::DETAIL, Action::EDIT, Action::DETAIL]);
		}
		return $actions;
	}

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('label.account_provider')
            ->setEntityLabelInPlural('label.account_providers')
	    ;
    }

    public function configureFields(string $pageName): iterable
    {
	    $id = IntegerField::new('id', 'label.id');
        $name = TextField::new('name', 'label.name');
	    $URL = URLField::new('URL', 'label.URL');
        $createdAt = DateTimeField::new('createdAt', 'label.created_at');
        $updatedAt = DateTimeField::new('updatedAt', 'label.updated_at');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $URL, $createdAt, $updatedAt];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
	        return [$id, $name, $URL, $createdAt, $updatedAt];
        } elseif (Crud::PAGE_NEW === $pageName) {
	        return [$name, $URL];
        } elseif (Crud::PAGE_EDIT === $pageName) {
	        return [$name, $URL];
        }
    }
}
