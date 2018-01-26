<?php

namespace HS\ListingBundle\Tests\Repository;

use HS\ListingBundle\Entity\Listing;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProductRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->em = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }


    public function testGetUserListings()
    {
    	$listings = $this->em->getRepository(Listing::class)->getUserListings(3);

    	$this->assertInternalType("array", $listings);
    	$firstListing = $listings[0];
    	$this->assertInstanceOf(Listing::class, $firstListing);
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->em->close();
        $this->em = null; // avoid memory leaks
    }
}