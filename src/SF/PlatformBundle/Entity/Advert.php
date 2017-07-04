<?php

namespace SF\PlatformBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

// N'oubliez pas de rajouter ce « use », il définit le namespace pour les annotations de validation
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

// Ajoutez ce use pour le contexte
use Symfony\Component\Validator\Context\ExecutionContextInterface;

// Verifie une donnée unique
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use SF\PlatformBundle\Validator\Antiflood;

/**
 * @ORM\Table(name="advert")
 * @ORM\Entity(repositoryClass="SF\PlatformBundle\Repository\AdvertRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields="title", message="Une annonce existe déjà avec ce titre.")
 */
class Advert
{
  /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @ORM\Column(name="date", type="datetime")
   * @Assert\DateTime()
   */
  private $date;

  /**
   * @ORM\Column(name="title", type="string", length=255)
   * @Assert\Length(min=10, minMessage="Le titre doit faire au moins {{ limit }} caractères.")
   */
  private $title;

  /**
   * @ORM\ManyToOne(targetEntity="SF\UserBundle\Entity\User")
   */
  private $user;

  /**
   * @ORM\Column(name="author", type="string", length=255)
   * @Assert\Length(min=2)
   */
  private $author;

  /**
   * @ORM\Column(name="content", type="string", length=255)
   * @Assert\NotBlank()
   * @Antiflood()
   */
  private $content;

  /**
   * @ORM\Column(name="published", type="boolean")
   */
  private $published = true;

  /**
   * @ORM\OneToOne(targetEntity="SF\PlatformBundle\Entity\Image", cascade={"persist", "remove"}))
   * @Assert\Valid()
   */
  private $image;

  /**
   * @ORM\ManyToMany(targetEntity="SF\PlatformBundle\Entity\Category", cascade={"persist"})
   * @ORM\JoinTable(name="advert_category")
   */
  private $categories;

  /**
   * @ORM\OneToMany(targetEntity="SF\PlatformBundle\Entity\AdvertSkill", mappedBy="advert", cascade={"persist", "remove"})
   * @ORM\JoinTable(name="advert_skill")
  */
  private $skills;

  /**
   * @ORM\OneToMany(targetEntity="SF\PlatformBundle\Entity\Application", mappedBy="advert")
   */
  private $applications; // Notez le « s », une annonce est liée à plusieurs candidatures

  /**
   * @ORM\Column(name="updated_at", type="datetime", nullable=true)
   */
  private $updatedAt;

  /**
   * @ORM\Column(name="nb_applications", type="integer")
   */
  private $nbApplications = 0;

  /**
   * @Gedmo\Slug(fields={"title"})
   * @ORM\Column(name="slug", type="string", length=255, unique=true)
   */
  private $slug;

  public function __construct()
  {
    $this->date         = new \Datetime();
    $this->categories   = new ArrayCollection();
    $this->skills   = new ArrayCollection();
    $this->applications = new ArrayCollection();
  }

  /**
   * @ORM\PreUpdate
   */
  public function updateDate()
  {
    $this->setUpdatedAt(new \Datetime());
  }

  public function increaseApplication()
  {
    $this->nbApplications++;
  }

  public function decreaseApplication()
  {
    $this->nbApplications--;
  }

  /**
   * @return int
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * @param \DateTime $date
   */
  public function setDate($date)
  {
    $this->date = $date;
  }

  /**
   * @return \DateTime
   */
  public function getDate()
  {
    return $this->date;
  }

  /**
   * @param string $title
   */
  public function setTitle($title)
  {
    $this->title = $title;
  }

  /**
   * @return string
   */
  public function getTitle()
  {
    return $this->title;
  }

  /**
   * @param string $author
   */
  public function setAuthor($author)
  {
    $this->author = $author;
  }

  /**
   * @return string
   */
  public function getAuthor()
  {
    return $this->author;
  }

  /**
   * @param string $content
   */
  public function setContent($content)
  {
    $this->content = $content;
  }

  /**
   * @return string
   */
  public function getContent()
  {
    return $this->content;
  }

  /**
   * @param bool $published
   */
  public function setPublished($published)
  {
    $this->published = $published;
  }

  /**
   * @return bool
   */
  public function getPublished()
  {
    return $this->published;
  }

  public function setImage(Image $image = null)
  {
    $this->image = $image;
  }

  public function getImage()
  {
    return $this->image;
  }

  /**
   * @param Category $category
   */
  public function addCategory(Category $category)
  {
    $this->categories[] = $category;
  }

  /**
   * @param Category $category
   */
  public function removeCategory(Category $category)
  {
    $this->categories->removeElement($category);
  }

  /**
   * @return ArrayCollection
   */
  public function getCategories()
  {
    return $this->categories;
  }

  /**
   * @param AdvertSkill $skill
   */
  public function addSkill(AdvertSkill $skill)
  {
    $this->skills[] = $skill;
  }

  /**
   * @param SkAdvertSkillill $skill
   */
  public function removeSkill(AdvertSkill $skill)
  {
    $this->skills->removeElement($skill);
  }

  /**
   * @return ArrayCollection
   */
  public function getSkills()
  {
    return $this->skills;
  }

  /**
   * @param Application $application
   */
  public function addApplication(Application $application)
  {
    $this->applications[] = $application;

    // On lie l'annonce à la candidature
    $application->setAdvert($this);
  }

  /**
   * @param Application $application
   */
  public function removeApplication(Application $application)
  {
    $this->applications->removeElement($application);
  }

  /**
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getApplications()
  {
    return $this->applications;
  }

  /**
   * @param \DateTime $updatedAt
   */
  public function setUpdatedAt(\Datetime $updatedAt = null)
  {
      $this->updatedAt = $updatedAt;
  }

  /**
   * @return \DateTime
   */
  public function getUpdatedAt()
  {
      return $this->updatedAt;
  }

  /**
   * @param integer $nbApplications
   */
  public function setNbApplications($nbApplications)
  {
      $this->nbApplications = $nbApplications;
  }

  /**
   * @return integer
   */
  public function getNbApplications()
  {
      return $this->nbApplications;
  }

  /**
   * @param string $slug
   */
  public function setSlug($slug)
  {
      $this->slug = $slug;
  }

  /**
   * @return string
   */
  public function getSlug()
  {
      return $this->slug;
  }

  /**
   * @Assert\Callback
   */
  public function isContentValid(ExecutionContextInterface $context)
  {

    $forbiddenWords = array('démotivation', 'abandon');

    // On vérifie que le contenu ne contient pas l'un des mots
    if (preg_match('#'.implode('|', $forbiddenWords).'#', $this->getContent())) {
      // La règle est violée, on définit l'erreur
      $context
        ->buildViolation('Contenu invalide car il contient un mot interdit.') // message
        ->atPath('content')                                                   // attribut de l'objet qui est violé
        ->addViolation() // ceci déclenche l'erreur, ne l'oubliez pas
      ;
    }
  }

    /**
     * Set user
     *
     * @param \SF\UserBundle\Entity\User $user
     *
     * @return Advert
     */
    public function setUser(\SF\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \SF\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
