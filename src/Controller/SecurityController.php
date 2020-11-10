<?php

namespace App\Controller;

use App\Service\Loader;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
	/**
	 * @Route("/login", name="app_login")
	 * @param AuthenticationUtils $authenticationUtils
	 * @param Loader              $loader
	 * @return Response
	 */
    public function login(AuthenticationUtils $authenticationUtils, Loader $loader): Response
    {
        if ($this->getUser()) {
        	return $this->redirectToRoute('app_dashboard');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $business = $loader->getBusiness();

        return $this->render('@EasyAdmin/page/login.html.twig', [
        	'last_username' => $lastUsername,
	        'error' => $error,
	        'page_title' => null === $business ? null : $business->getName(),
	        'username_parameter' => 'email',
	        'password_parameter' => 'password',
	        'csrf_token_intention' => 'authenticate',
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
