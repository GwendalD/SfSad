<?php
// src/SF/PlatformBundle/Repository/CategoryRepository.php

namespace SF\PlatformBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository
{
  public function getLikeQueryBuilder($pattern)
  {
    return $this
      ->createQueryBuilder('c')
      ->where('c.name LIKE :pattern')
      ->setParameter('pattern', $pattern)
    ;
  }
}
