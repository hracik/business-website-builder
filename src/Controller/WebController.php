<?php
namespace App\Controller;

use App\Entity\Business;
use App\Entity\Envelope;
use App\Form\ContactFormType;
use App\Service\Loader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WebController extends AbstractController
{

	/**
	 * @Route("/", name="app_index")
	 * @param Request $request
	 * @param Loader  $loader
	 * @param array   $settings
	 * @return Response
	 */
	public function index(Request $request, Loader $loader, array $settings)
	{
		$business = $loader->getBusiness();
		if (null === $business) {
			return $this->redirectToRoute('app_instructions');
		}

		$formSuccess = false;
		if (true === $settings['contactForm']) {
			$form = $this->createForm(ContactFormType::class);
			$form->handleRequest($request);
			if ($form->isSubmitted() && $form->isValid()) {
				$formSuccess = true;
				$email = $form->get('email')->getData();
				$message = $form->get('message')->getData();

				$envelope = new Envelope();
				$envelope->setEmail($email);
				$envelope->setMessage($message);
				$manager = $this->getDoctrine()->getManager();
				$manager->persist($envelope);
				$manager->flush();
			}
		}

		return $this->render('index.html.twig', [
			'business' => $business,
			'form' => isset($form) ? $form->createView() : null,
			'formSuccess' => $formSuccess,
		]);
	}

	/**
	 * @Route("/instructions", name="app_instructions")
	 * @param Loader $loader
	 * @return Response
	 */
	public function instructions(Loader $loader)
	{
		$business = $loader->getBusiness();
		if ($business instanceof Business) {
			return $this->redirectToRoute('app_index');
		}

		return $this->render('instructions.html.twig');
	}
}