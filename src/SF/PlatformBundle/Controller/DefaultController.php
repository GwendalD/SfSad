<?php

namespace SF\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SFPlatformBundle:Default:index.html.twig');
    }
}
