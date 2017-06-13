<?php
// src/SF/PlatformBundle/Twig/AntispamExtension.php

namespace SF\PlatformBundle\Twig;

use SF\PlatformBundle\Antispam\SFAntispam;

class AntispamExtension
{
  /**
   * @var OCAntispam
   */
  private $ocAntispam;

  public function __construct(OCAntispam $ocAntispam)
  {
    $this->ocAntispam = $ocAntispam;
  }

  public function checkIfArgumentIsSpam($text)
  {
    return $this->ocAntispam->isSpam($text);
  }
}