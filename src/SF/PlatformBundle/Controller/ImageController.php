<?php

// src/SF/PlatformBundle/Controller/ImageController.php

namespace SF\PlatformBundle\Controller;

use SF\PlatformBundle\Entity\Advert;
use SF\PlatformBundle\Entity\Image;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ImageController extends Controller
{
  public function editImageAction($advertId)
  {
    $em = $this->getDoctrine()->getManager();

    // On récupère l'annonce
    $advert = $em->getRepository('SFPlatformBundle:Advert')->find($advertId);

    // On modifie l'URL de l'image par exemple
    $advert->getImage()->setUrl('test.png');

    // On n'a pas besoin de persister l'annonce ni l'image.
    // Rappelez-vous, ces entités sont automatiquement persistées car
    // on les a récupérées depuis Doctrine lui-même
    
    // On déclenche la modification
    $em->flush();

    return new Response('OK');
  }
}