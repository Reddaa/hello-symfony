<?php


namespace HS\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use HS\ListingBundle\Entity\Listing;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
 class User extends BaseUser
 {

    //initiating a construct to initialize future fields
    public function __construct()
    {
        $listings = new ArrayCollection();
        parent::__construct();

    }

 	/**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    
    /**
     * One User has Many Listings.
     *
     * @ORM\OneToMany(targetEntity="HS\ListingBundle\Entity\Listing", mappedBy="user")
     */
    private $listings;

     /**
      * One User has Many Orders.
      * @ORM\OneToMany(targetEntity="HS\UserBundle\Entity\User", mappedBy="user")
      */
    private $orders;

    /**
     * One User has Many Listings viewed.
     *
     * @ORM\OneToMany(targetEntity="HS\ListingBundle\Entity\ListingMetric", mappedBy="user")
     */
    private $listingViews;



    public function getListings()
    {
        return $this->listings;
    }

    public function setListings($listings)
    {
        $this->listings = $listings;
    }

    public function getListingViews()
    {
        return $this->listingViews;
    }

    public function setListingViews($listingViews)
    {
        $this->listingViews = $listingViews;
    }

     /**
      * @return mixed
      */
     public function getOrders()
     {
         return $this->orders;
     }

     /**
      * @param mixed $orders
      */
     public function setOrders($orders)
     {
         $this->orders = $orders;
     }


 }