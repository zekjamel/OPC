<?php

// src/JG/PlatformBundle/Controller/AdvertController.php

namespace JG\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class AdvertController extends Controller
{
    public function indexAction($page)
    {	
		if ($page < 1) {
			// On déclenche une exception NotFoundHttpException, cela va afficher
			// une page d'erreur 404 (qu'on pourra personnaliser plus tard d'ailleurs)
			throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
		}
		$listAdverts = array(
		  array(
			'title'   => 'Recherche développpeur Symfony',
			'id'      => 1,
			'author'  => 'Alexandre',
			'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
			'date'    => new \Datetime()),
		  array(
			'title'   => 'Mission de webmaster',
			'id'      => 2,
			'author'  => 'Hugo',
			'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
			'date'    => new \Datetime()),
		  array(
			'title'   => 'Offre de stage webdesigner',
			'id'      => 3,
			'author'  => 'Mathieu',
			'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
			'date'    => new \Datetime())
		);

    // Et modifiez le 2nd argument pour injecter notre liste
		return $this->render('JGPlatformBundle:Advert:index.html.twig', array(
			'listAdverts' => $listAdverts
		));
    }

	
	public function viewAction($id)
	{
		// Ici, on récupérera l'annonce correspondante à l'id $id

		$advert = array(
		  'title'   => 'Recherche développpeur Symfony2',
		  'id'      => $id,
		  'author'  => 'Alexandre',
		  'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
		  'date'    => new \Datetime()
		);

		return $this->render('JGPlatformBundle:Advert:view.html.twig', array(
		  'advert' => $advert
		));
	}
	
	public function viewSlugAction($slug, $year, $_format)
	{
		return new Response("On pourrait afficher l'annonce correspondant au slug '".$slug."', créée en ".$year." et au format ".$format.".");
	}
	
	// Ajoutez cette méthode :
	public function addAction(Request $request)
	{
		/*// On récupère le service
		$antispam = $this->container->get('jg_platform.antispam');

		// Je pars du principe que $text contient le texte d'un message quelconque
		$text = '...';
		if ($antispam->isSpam($text)) {
		  throw new \Exception('Votre message a été détecté comme spam !');
		}
		
		// Ici le message n'est pas un spam
		*/
		// La gestion d'un formulaire est particulière, mais l'idée est la suivante :

		// Si la requête est en POST, c'est que le visiteur a soumis le formulaire
		if ($request->isMethod('POST')) {
			// Ici, on s'occupera de la création et de la gestion du formulaire

			$request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

			// Puis on redirige vers la page de visualisation de cettte annonce
      return $this->redirectToRoute('jg_platform_view', array('id' => 5));
    }

    // Si on n'est pas en POST, alors on affiche le formulaire
    return $this->render('JGPlatformBundle:Advert:add.html.twig');
	}
	
	public function editAction($id, Request $request)
	{
    // ...
    
		$advert = array(
		  'title'   => 'Recherche développpeur Symfony',
		  'id'      => $id,
		  'author'  => 'Alexandre',
		  'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
		  'date'    => new \Datetime()
		);

		return $this->render('JGPlatformBundle:Advert:edit.html.twig', array(
			'advert' => $advert
		));
	}
  
	public function menuAction()
  {
    // On fixe en dur une liste ici, bien entendu par la suite
    // on la récupérera depuis la BDD !
    $listAdverts = array(
      array('id' => 2, 'title' => 'Recherche développeur Symfony'),
      array('id' => 5, 'title' => 'Mission de webmaster'),
      array('id' => 9, 'title' => 'Offre de stage webdesigner')
    );

    return $this->render('JGPlatformBundle:Advert:menu.html.twig', array(
      // Tout l'intérêt est ici : le contrôleur passe
      // les variables nécessaires au template !
      'listAdverts' => $listAdverts
    ));
  }
}