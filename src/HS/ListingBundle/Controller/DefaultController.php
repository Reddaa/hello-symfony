<?php

namespace HS\ListingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Doctrine\ORM\EntityManager;
use HS\ListingBundle\Repository\ListingRepository;
use HS\ListingBundle\Entity\Listing;
use HS\ListingBundle\Form\ListingType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;




class DefaultController extends Controller
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
        return $this->render('HSListingBundle:Listing:index.html.twig', array(
            'listings' => $listings
        ));
    }

    /**
     * 
     * @Security("has_role('ROLE_USER')")
     * @Route("/manage/listing", name="hs_listing_add")
     * @Method({"POST"})
     */
    public function addAction(Request $request, ListingRepository $listingRepository)
    {
        $listing = new Listing();
        $formResult = $this->get('form.factory')->create(ListingType::class, $listing)
                            ->handleRequest($request);

        //if the listing is valid
        if ($request->isMethod('POST') && $formResult->isValid()) {

            //we set the owner of the listing to the current connected user
            $listing->setUser($this->getUser());            

            $listingRepository->addListing($listing);
            
            $request->getSession()->getFlashBag()->add('notice', 'Saved');
            
            return $this->redirectToRoute('hs_listing_index');
        }

        return $this->render("HSListingBundle:Listing:add.html.twig", array(
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

        return $this->render("HSListingBundle:Listing:add.html.twig", array(
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
    public function viewListing(Listing $listing, ListingRepository $listingRepository)
    {
        if ($listing == null)
            throw $this->createNotFoundException("entity not found");
        $this->get('hs_stat_calculator')->addListingView($listing, $this->getUser());
        
        $viewsCount = $listing->getListingViews($this->getUser());
        return $this->render("HSListingBundle:Listing:view.html.twig", array(
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
            throw $this->createNotFoundException("Listing not found");
        $listing->setPhoto(null);
        $form = $this->get('form.factory')->create(ListingType::class, $listing);
        $formResult = $form->handleRequest($request);

        return $this->render("HSListingBundle:Listing:add.html.twig", array(
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
}
