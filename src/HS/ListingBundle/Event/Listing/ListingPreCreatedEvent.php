<?php
/**
 * Created by PhpStorm.
 * User: Redaa
 * Date: 2/1/2018
 * Time: 3:38 PM
 */

namespace HS\ListingBundle\Event\Listing;


use HS\ListingBundle\Entity\Listing;
use HS\UserBundle\Entity\User;
use Symfony\Component\Workflow\Event\Event;

class ListingPreCreatedEvent extends Event
{
    const NAME = "listing.pre_created";

    protected $listing;
    protected $user;

    /**
     * ListingPostCreatedEvent constructor.
     * @param Listing $listing
     * @param User $user
     */
    public function __construct(Listing $listing, User $user)
    {
        $this->listing = $listing;
        $this->user  = $user;
    }

    /**
     * @return Listing
     */
    public function getListing() : Listing
    {
        return $this->listing;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}