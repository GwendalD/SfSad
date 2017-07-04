<?php
// src/SF/UserBundle/OCUserBundle.php

namespace SF\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SFUserBundle extends Bundle
{
  public function getParent()
  {
    return 'FOSUserBundle';
  }
}