<?php
// src/SF/PlatformBundle/Entity/AdvertCategory.php

namespace SF\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="advert_category")
 */
class AdvertCategory
{
  /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;
  
  /**
   * @ORM\Column(name="advert_id", type="integer")
   */
  private $advertId;

  /**
   * @ORM\Column(name="category_id", type="integer")
   */
  private $categoryId;

  public function setAdvertId($advertId)
  {
    $this->advertId = $advertId;
  }

  public function getAdvertId()
  {
    return $this->advertId;
  }

  public function setCategoryId($categoryId)
  {
    $this->categoryId = $categoryId;
  }

  public function getCategoryId()
  {
    return $this->categoryId;
  }
}