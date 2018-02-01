<?php

namespace HS\ListingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use HS\UserBundle\Entity\User;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;



/**
 * Listing
 *
 * @ORM\Table(name="listing")
 * @ORM\Entity(repositoryClass="HS\ListingBundle\Repository\ListingRepository")
 * @UniqueEntity(fields="name", message="Liting with same name already exists")
 * 
 */
class Listing
{


    public function __construct() {
        $this->views = new ArrayCollection();
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="size", type="string", length=20)
     */
    private $size;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * Many Listings have One user.
     * @ORM\ManyToOne(targetEntity="HS\UserBundle\Entity\User", inversedBy="listings")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="HS\ListingBundle\Entity\ListingMetric", mappedBy="listing")
     */
    private $views;


    /**
     * 
     * Get views
     * 
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * 
     * Set views
     * 
     **/
    public function setViews($views)
    {
        $this->views = $views;
    }

    /**
     * 
     * Get Category
     * 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * 
     * Set Category
     * 
     **/
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * Get user 
     *
     * gets the user of the listing
     */
    public function getUser()
    {
        return $this->user;
    }


    /**
     * Set user
     *
     * sets the user of the listing
     * @return int
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Listing
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set size
     *
     * @param string $size
     *
     * @return Listing
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Listing
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return Listing
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Return unique views of the article
     * @param 
     * @return int
     */
    public function getUniqueViews()
    {
        return count($this->views);
    }

    /**
     * Return how many time the user viewed the listing
     * @param type $user 
     * @return type int
     */
    public function getListingViews($user)
    {

        $criteria = Criteria::create()
        ->where(Criteria::expr()->eq("user", $user));
        
        $views = $this->views->matching($criteria);
        $count = 0;
        foreach ($views as $view) {
            $count += $view->getViews();
        }
        return $count;
    }
}

