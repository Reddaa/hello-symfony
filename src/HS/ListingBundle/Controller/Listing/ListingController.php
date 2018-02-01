<?php

namespace HS\ListingBundle\Controller\Listing;

use HS\ListingBundle\Entity\Listing;
use HS\ListingBundle\Entity\ListingMetric;
use HS\ListingBundle\Repository\ListingMetricRepository;
use HS\ListingBundle\Repository\ListingRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Created by PhpStorm.
 * User: Redaa
 * Date: 2/1/2018
 * Time: 9:40 AM
 */

class ListingController extends Controller {

    /**
     *
     * @Route("/listings", name="hs_listing_view_index")
     */
    public function indexAction(ListingRepository $listingRepository) {

        //get listings from repository
        $listings = $listingRepository->getListings();

        //render view and send $listings as argument
        return $this->render('HSListingBundle:Listing:list.html.twig', array(
            'listings' => $listings
        ));
    }

    /**
     *
     * @Route("/listing/{id}", name="hs_listing_view_listing")
     * @Security("listing.getActive() == true")
    */
    public function viewAction(Listing $listing, ListingMetricRepository $listingMetricRepository) {

        //For now we don't need the throw notfoundexception since doctrine throws it automatically
        //maybe later when we need to do more custom business login on the listing object
        if ($listing == null)
            throw new NotFoundHttpException("Not found");
        $this->get('hs_stat_calculator')->addListingView($listing, $this->getUser());

        $viewsCount = $listingMetricRepository->getListingViews($listing, $this->getUser());
        //render view and send $listings as argument
        return $this->render('HSListingBundle:Listing:view.html.twig', array(
            'listing' => $listing,
            'viewsCount' => $viewsCount
        ));
    }
}