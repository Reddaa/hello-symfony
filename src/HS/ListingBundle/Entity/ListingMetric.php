<?php

namespace HS\ListingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ListingMetric
 *
 * @ORM\Table(name="listing_metric")
 * @ORM\Entity(repositoryClass="HS\ListingBundle\Repository\ListingMetricRepository")
 */
class ListingMetric
{

    public function __construct()
    {
        $this->views = 0;
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
     * @var int
     *
     * @ORM\Column(name="views", type="bigint")
     */
    private $views;

    /**
     * 
     * @var Listing
     * 
     *@ORM\ManyToOne(targetEntity="HS\ListingBundle\Entity\Listing", inversedBy="views")
     *@ORM\JoinColumn(nullable=true)
     * 
     */
    private $listing;

    /**
     * 
     * @var User
     * 
     *@ORM\ManyToOne(targetEntity="HS\UserBundle\Entity\User", inversedBy="listingViews")
     *@ORM\JoinColumn(nullable=true)
     * 
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
     * Set views
     *
     * @param integer $views
     *
     * @return ListingMetric
     */
    public function setViews($views)
    {
        $this->views = $views;

        return $this;
    }

    /**
     * Get views
     *
     * @return int
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Get User
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set User
     *
     * @param User $user
     *
     * @return ListingMetric
     */
    public function setUser($user)
    {
        $this->user = $user;

    }

    /**
     * Get Listing
     *
     * @return Listing
     */
    public function getListing()
    {
        return $this->listing;
    }

    /**
     * Set Listing
     *
     * @param Listing $listing
     *
     * @return void
     */
    public function setListing($listing)
    {
        $this->listing = $listing;

    }


}

