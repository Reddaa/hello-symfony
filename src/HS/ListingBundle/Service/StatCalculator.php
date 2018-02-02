<?php 

namespace HS\ListingBundle\Service;

use HS\ListingBundle\Entity\ListingMetric;
use HS\ListingBundle\Repository\ListingMetricRepository;

/**
* Service to calculat stat
*/
class StatCalculator
{
	
	private $entityManager;

	function __construct($entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function addListingView($listing, $user)
	{
		if ($listing == null)
			return;
		
		$repository = $this->entityManager->getRepository(ListingMetric::class);

		$repository->addListingView($listing, $user);
	}
}