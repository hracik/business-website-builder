<?php

namespace App\Controller;

use App\Entity\AccountProvider;
use App\Entity\BankAccount;
use App\Entity\Business;
use App\Entity\CryptoCurrencyAccount;
use App\Entity\Envelope;
use App\Entity\ServiceAccount;
use App\Entity\User;
use App\Service\Loader;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractDashboardController
{

	private $loader;

	public function __construct(Loader $loader)
	{
		$this->loader = $loader;
	}

    /**
     * @Route("/dashboard", name="app_dashboard")
     */
    public function index(): Response
    {
	    return $this->render('dashboard.html.twig');
    }

	public function configureAssets(): Assets
	{
		/**
		 * https://symfony.com/doc/current/bundles/EasyAdminBundle/design.html
		 * However, if you want total control over the backend styles,
		 * you can use Webpack to integrate the SCSS and JavaScript source files provided in the assets/ directory.
		 * The only caveat is that EasyAdmin doesn’t use Webpack Encore yet when loading the assets,
		 * so you can’t use features like versioning.
		 * This will be fixed in future versions.
		 */
		/* easyadmin fixes */
		return Assets::new()->addHtmlContentToHead(
			'<style>
				.ea-vich-image-actions .form-group{
				    padding: 0 !important;
				}
			</style>'
		);
	}

	public function configureCrud(): Crud
	{
		return Crud::new()
			// set it to null to disable and hide the search box
			->setSearchFields(null)
			->showEntityActionsAsDropdown()
			->setFormOptions(['attr' => ['novalidate' => 'novalidate']])
			->setDateFormat('full')
			;
	}

	public function configureUserMenu(UserInterface $user): UserMenu
	{
		return parent::configureUserMenu($user)
			->displayUserAvatar(false);
	}

	public function configureDashboard(): Dashboard
    {
    	$business = $this->loader->getBusiness();
        return Dashboard::new()
            ->setTitle(null === $business ? 'Dashboard' : $business->getName())
	        ->setTranslationDomain('easyadmin');
    }

    public function configureMenuItems(): iterable
    {
	    yield MenuItem::linkToCrud('label.user', 'fas fa-users', User::class);
	    yield MenuItem::linkToCrud('label.business', 'fas fa-building', Business::class);
	    $business = $this->loader->getBusiness();
	    if (null !== $business) {
		    yield MenuItem::linkToCrud('label.envelope', 'fas fa-envelope-open-text', Envelope::class);
		    yield MenuItem::linkToCrud('label.account_provider', 'fas fa-university', AccountProvider::class);
		    yield MenuItem::section('label.accounts');
		    yield MenuItem::linkToCrud('label.bank_account', 'fas fa-piggy-bank', BankAccount::class);
		    yield MenuItem::linkToCrud('label.crypto_currency_account', 'fab fa-bitcoin', CryptoCurrencyAccount::class);
		    yield MenuItem::linkToCrud('label.service_account', 'fas fa-database', ServiceAccount::class);
	    }
    }
}
