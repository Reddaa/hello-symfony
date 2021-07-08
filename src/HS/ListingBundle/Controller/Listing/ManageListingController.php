<?php

namespace HS\ListingBundle\Controller\Listing;

use HS\ListingBundle\Event\Listing\ListingPostCreatedEvent;
use HS\ListingBundle\Event\Listing\ListingPreCreatedEvent;
use HS\ListingBundle\Repository\ListingMetricRepository;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Doctrine\ORM\EntityManager;
use HS\ListingBundle\Repository\ListingRepository;
use HS\ListingBundle\Entity\Listing;
use HS\ListingBundle\Form\ListingType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;




class ManageListingController extends Controller
{
    
    /**
     * 
     * @Security("has_role('ROLE_USER')")
     * @Route("/manage/listings", name="hs_listing_index")
     */
    public function indexAction(ListingRepository $listingRepository)
    {
        //current connected user
    	$user = $this->getUser();

        //get listings from repository    
        $listings = $listingRepository->getUserListings($user->getId());

        //render view and send $listings as argument
        return $this->render('HSListingBundle:ManageListing:index.html.twig', array(
            'listings' => $listings
        ));
    }

    /**
     *
     * @Security("has_role('ROLE_USER')")
     * @Route("/manage/listing", name="hs_listing_add")
     * @Method({"POST"})
     *
     * @param Request $request
     * @param ListingRepository $listingRepository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function addAction(Request $request, ListingRepository $listingRepository)
    {
        $listing = new Listing();
        $form = $this->get('form.factory')->create(ListingType::class, $listing);
        //if the listing is valid
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            //we dispatch the event to listener about pre creation of a listing
            $dispatcher = $this->get("event_dispatcher");

            $event = new ListingPreCreatedEvent($listing, $this->getUser());
            $dispatcher->dispatch(ListingPreCreatedEvent::NAME, $event);

            //we set the owner of the listing to the current connected user
            $listing->setUser($this->getUser());            

            $listingRepository->addListing($listing);

            //same here, after the listing is created we dispatch that event to listeners
            $event = new ListingPostCreatedEvent($listing, $this->getUser());
            $dispatcher->dispatch(ListingPostCreatedEvent::NAME, $event);

            $request->getSession()->getFlashBag()->add('notice', 'Saved');
            
            return $this->redirectToRoute('hs_listing_index');
        }

        return $this->render("HSListingBundle:ManageListing:add.html.twig", array(
            'form' => $form->createView()
        ));
        
    }

    /**
     * renders the listing form to update or edit the listing
     * 
     * @Security("has_role('ROLE_USER')")
     * @Route("/manage/listing", name="hs_listing_render_form")
     * @Method({"GET"})
     **/
    public function renderListingForm(Request $request)
    {
        $listing = new Listing();
        $form = $this->get('form.factory')->create(ListingType::class, $listing);

        return $this->render("HSListingBundle:ManageListing:add.html.twig", array(
            'form' => $form->createView()
        ));
    }

    /**
     * view a listing by id
     * 
     * @Security("has_role('ROLE_USER')")
     * @Route("/manage/listing/{id}", name="hs_listing_view")
     * @Method({"GET"})
     **/
    public function viewListing(Listing $listing, ListingMetricRepository $listingRepository)
    {
        if ($listing == null)
            throw $this->createNotFoundException("entity not found");
        $this->get('hs_stat_calculator')->addListingView($listing, $this->getUser());
        
        $viewsCount = $listingRepository->getListingViews($listing, $this->getUser());
        return $this->render("HSListingBundle:ManageListing:view_listing.html.twig", array(
            'listing' => $listing,
            'viewsCount' => $viewsCount
        ));
    }

    /**
     * view a listing by id
     * 
     * @Security("has_role('ROLE_USER')")
     * @Route("/manage/listing/edit/{id}", name="hs_listing_edit")
     * @Method({"GET"})
     **/
    public function editListing(Request $request, Listing $listing, ListingRepository $listingRepository)
    {
        if ($listing == null)
            throw $this->createNotFoundException("ManageListing not found");
        $listing->setPhoto(null);
        $form = $this->get('form.factory')->create(ListingType::class, $listing);
        $formResult = $form->handleRequest($request);

        return $this->render("HSListingBundle:ManageListing:add.html.twig", array(
            'form' => $form->createView()
        ));
    }

    /**
     * delete a listing 
     * 
     * @Security("has_role('ROLE_USER')")
     * @Route("/manage/listing/delete/{id}", name="hs_listing_delete")
     * @Method({"GET"}) 
     **/
    public function deleteListing(Listing $listing = null, ListingRepository $listingRepository)
    {
        
        if ($listing == null) 
            throw $this->createNotFoundException('Sorry not existing');

        $listingRepository->delete($listing);
        
        return $this->redirectToRoute("hs_listing_index", array());
    }

    /**
     * @param Listing $listing
     * @param ListingRepository $listingRepository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/manage/listing/status/{id}", name="hs_listing_change_status")
     * @Method({"GET"})
     */
    public function changeListingActive(Listing $listing, ListingRepository $listingRepository) {
        if ($listing == null)
            throw $this->createNotFoundException('Sorry not existing');

        $listingRepository->changeStatus($listing);

        return $this->redirectToRoute("hs_listing_index", array());
    }
}
