<?php

namespace App\Controller\Crud;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

	public function configureActions(Actions $actions): Actions
	{
		// this will forbid to create or delete User in the backend
		return $actions->disable(Action::NEW, Action::DELETE, Action::DETAIL);
	}

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('label.user')
            ->setEntityLabelInPlural('label.users')
	    ;
    }

    public function configureFields(string $pageName): iterable
    {
	    $id = IntegerField::new('id', 'label.id');
        $email = TextField::new('email', 'label.email');
        $createdAt = DateTimeField::new('createdAt', 'label.created_at');
        $updatedAt = DateTimeField::new('updatedAt', 'label.updated_at');
        //todo edit password field

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $email, $createdAt, $updatedAt];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$email];
        }
    }
}
