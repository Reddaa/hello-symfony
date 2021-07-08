<?php

namespace HS\ListingBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use HS\UserBundle\Entity\User;

/**
 * LOrder
 *
 * @ORM\Table(name="l_order")
 * @ORM\Entity(repositoryClass="HS\ListingBundle\Repository\LOrderRepository")
 */
class LOrder
{

    public function __construct($listings, $user)
    {
        $this->listings = $listings;
        $this->user = $user;
        $this->dateOrder = new \DateTime();
        $this->currency = "EUR";
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
     * @var \DateTime
     *
     * @ORM\Column(name="date_order", type="datetime")
     */
    private $dateOrder;

    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="string", length=255)
     */
    private $currency;

    /**
     * @var arraylist
     *
     * @ORM\ManyToMany(targetEntity="HS\ListingBundle\Entity\Listing", inversedBy="")
     * @ORM\JoinTable(name="listings_orders")
     */
    private $listings;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="HS\UserBundle\Entity\User",inversedBy="orders")
     * @ORM\JoinColumn(name = "user_id", referencedColumnName="id")
     */
    private $user;


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
     * Set dateOrder
     *
     * @param \DateTime $dateOrder
     *
     * @return LOrder
     */
    public function setDateOrder($dateOrder)
    {
        $this->dateOrder = $dateOrder;

        return $this;
    }

    /**
     * Get dateOrder
     *
     * @return \DateTime
     */
    public function getDateOrder()
    {
        return $this->dateOrder;
    }

    /**
     * Set currency
     *
     * @param string $currency
     *
     * @return LOrder
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @return arraylist
     */
    public function getListings()
    {
        return $this->listings;
    }

    /**
     * @param arraylist $listings
     */
    public function setListings($listings)
    {
        $this->listings = $listings;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }


}

