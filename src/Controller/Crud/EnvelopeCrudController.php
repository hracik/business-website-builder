<?php

namespace App\Controller\Crud;

use App\Entity\Envelope;
use App\Service\Loader;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EnvelopeCrudController extends AbstractCrudController
{
	private $loader;

	public function __construct(Loader $loader)
	{
		$this->loader = $loader;
	}


	public static function getEntityFqcn(): string
    {
        return Envelope::class;
    }

	public function configureActions(Actions $actions): Actions
	{
		if (null === $this->loader->getBusiness()) {
			$actions->disable(Action::INDEX, Action::DETAIL, Action::NEW,  Action::EDIT, Action::DELETE);
		}

		// this will forbid to create or edit Envelope in the backend
		return $actions->disable(Action::NEW, Action::EDIT);
	}

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('label.envelope')
            ->setEntityLabelInPlural('label.envelopes')
	    ;
    }

    public function configureFields(string $pageName): iterable
    {
	    $id = IntegerField::new('id', 'label.id');
        $email = TextField::new('email', 'label.email');
	    $message = TextareaField::new('message', 'label.message');
        $createdAt = DateTimeField::new('createdAt', 'label.created_at');
        $updatedAt = DateTimeField::new('updatedAt', 'label.updated_at');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $email, $message, $createdAt, $updatedAt];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
	        return [$id, $email, $message, $createdAt, $updatedAt];
        }
    }
}
