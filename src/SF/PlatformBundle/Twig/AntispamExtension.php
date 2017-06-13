<?php
// src/SF/PlatformBundle/Twig/AntispamExtension.php

namespace SF\PlatformBundle\Twig;

use SF\PlatformBundle\Antispam\SFAntispam;

class AntispamExtension extends \Twig_Extension
{
  /**
   * @var SFAntispam
   */
  private $sfAntispam;

  public function __construct(SFAntispam $sfAntispam)
  {
    $this->sfAntispam = $sfAntispam;
  }

  public function checkIfArgumentIsSpam($text)
  {
    return $this->sfAntispam->isSpam($text);
  }

  // Twig va exécuter cette méthode pour savoir quelle(s) fonction(s) ajoute notre service
  public function getFunctions()
  {
    return array(

      new \Twig_SimpleFunction('checkIfSpam', array($this, 'checkIfArgumentIsSpam')),

    );
  }

  // La méthode getName() identifie votre extension Twig, elle est obligatoire
  public function getName()
  {
    return 'SFAntispam';
  }

}