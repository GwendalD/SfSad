<?php

// src/SF/PlatformBundle/Controller/AdvertController.php

namespace SF\PlatformBundle\Controller;

use SF\PlatformBundle\Entity\Advert;
use SF\PlatformBundle\Entity\AdvertSkill;
use SF\PlatformBundle\Entity\Image;
use SF\PlatformBundle\Entity\Application;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdvertController extends Controller
{
  public function indexAction(Request $request, $page)
  {
    if ($page < 1) {
      throw $this->createNotFoundException("La page ".$page." n'existe pas.");
    }

    // Ici je fixe le nombre d'annonces par page à 3
    // Mais bien sûr il faudrait utiliser un paramètre, et y accéder via $this->container->getParameter('nb_per_page')
    $nbPerPage = 3;

    // On récupère notre objet Paginator
    $listAdverts = $this->getDoctrine()
      ->getManager()
      ->getRepository('SFPlatformBundle:Advert')
      ->findAllPagination()
    ;
    // Creating pagnination
    $paginator  = $this->get('knp_paginator');
    $paginationAdverts = $paginator->paginate(
        $listAdverts,
        $request->query->get('page', $page),
        1
    );

    // On donne toutes les informations nécessaires à la vue
    return $this->render('SFPlatformBundle:Advert:index.html.twig', array(
      'listAdverts' => $paginationAdverts
    ));


    // // On calcule le nombre total de pages grâce au count($listAdverts) qui retourne le nombre total d'annonces
    // $nbPages = ceil(count($listAdverts) / $nbPerPage);

    // // Si la page n'existe pas, on retourne une 404
    // if ($page > $nbPages) {
    //   throw $this->createNotFoundException("La page ".$page." n'existe pas.");
    // }

    // // On donne toutes les informations nécessaires à la vue
    // return $this->render('SFPlatformBundle:Advert:index.html.twig', array(
    //   'listAdverts' => $listAdverts,
    //   'nbPages'     => $nbPages,
    //   'page'        => $page,
    // ));
  }


  public function menuAction($limit)
  {

    // On récupère les annonces avec notre propre requete pour ne choisir que quelque champs
    $listAdverts = $this->getDoctrine()
      ->getManager()
      ->getRepository('SFPlatformBundle:Advert')
      ->getLastAdvertMenu($limit);


    return $this->render('SFPlatformBundle:Advert:menu.html.twig', array(
      // Tout l'intérêt est ici : le contrôleur passe
      // les variables nécessaires au template !
      'listAdverts' => $listAdverts
    ));
  }

  public function viewAction($id)
  {
    $em = $this->getDoctrine()->getManager();

    // Pour récupérer une seule annonce, on utilise la méthode find($id)
    $advert = $em->getRepository('SFPlatformBundle:Advert')->find($id);

    // $advert est donc une instance de SF\PlatformBundle\Entity\Advert
    // ou null si l'id $id n'existe pas, d'où ce if :
    if (null === $advert) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }

    // Récupération de la liste des candidatures de l'annonce
    $listApplications = $em
      ->getRepository('SFPlatformBundle:Application')
      ->findBy(array('advert' => $advert))
    ;

    // Récupération des AdvertSkill de l'annonce
    $listAdvertSkills = $em
      ->getRepository('SFPlatformBundle:AdvertSkill')
      ->findBy(array('advert' => $advert))
    ;

    return $this->render('SFPlatformBundle:Advert:view.html.twig', array(
      'advert'           => $advert,
      'listApplications' => $listApplications,
      'listAdvertSkills' => $listAdvertSkills,
    ));
  }

  public function addAction(Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    // On ne sait toujours pas gérer le formulaire, patience cela vient dans la prochaine partie !

    if ($request->isMethod('POST')) {
      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

      return $this->redirectToRoute('sf_platform_view', array('id' => $advert->getId()));
    }

    return $this->render('SFPlatformBundle:Advert:add.html.twig');
  }

  public function editAction($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    $advert = $em->getRepository('SFPlatformBundle:Advert')->find($id);

    if (null === $advert) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }

    // Ici encore, il faudra mettre la gestion du formulaire

    if ($request->isMethod('POST')) {
      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');

      return $this->redirectToRoute('sf_platform_view', array('id' => $advert->getId()));
    }

    return $this->render('SFPlatformBundle:Advert:edit.html.twig', array(
      'advert' => $advert
    ));
  }

  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getManager();

    $advert = $em->getRepository('SFPlatformBundle:Advert')->find($id);

    if (null === $advert) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }

    // On boucle sur les catégories de l'annonce pour les supprimer
    foreach ($advert->getCategories() as $category) {
      $advert->removeCategory($category);
    }

    $em->flush();
    
    return $this->render('SFPlatformBundle:Advert:delete.html.twig');
  }

  public function listAction()
  {
    $listAdverts = $this
      ->getDoctrine()
      ->getManager()
      ->getRepository('SFPlatformBundle:Advert')
      ->getAdvertWithApplications()
    ;

    foreach ($listAdverts as $advert) {
      // Ne déclenche pas de requête : les candidatures sont déjà chargées !
      // Vous pourriez faire une boucle dessus pour les afficher toutes
      $advert->getApplications();
    }
  }
}