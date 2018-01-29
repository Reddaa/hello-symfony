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
use OC\PlatformBundle\Event\MessagePostEvent;
use OC\PlatformBundle\Event\PlatformEvents;



class DefaultController extends Controller
{
    
    /**
     * 
     * @Security("has_role('ROLE_USER')")
     * @Route("/manage/listings", name="hs_listing_index")
     */
    public function indexAction()
    {
        //get entityManager 
        $listingRepository = $this->getDoctrine()->getManager()
            ->getRepository(Listing::class);

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
    public function addAction(Request $request)
    {
        $listing = new Listing();
        $form = $this->get('form.factory')->create(ListingType::class, $listing);

        $formResult = $form->handleRequest($request);
        //if the listing is valid
        if ($request->isMethod('POST') && $formResult->isValid()) {

            $newFile =  $this->get('hs_file_mover')->moveFile($listing->getPhoto(), 
                $this->getParameter('public_directory'));
            
            $listing->setPhoto($newFile);
            
            $listingRepository = $this->getDoctrine()->getManager()
                ->getRepository(Listing::class);

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
}
