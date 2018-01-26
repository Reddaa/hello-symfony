<?php

namespace HS\ListingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
     */
    public function addAction(Request $request)
    {
        $listing = new Listing();
        $form = $this->get('form.factory')->create(ListingType::class, $listing);

        //if the user submited the form to add
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $listing->setUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($listing);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
          return $this->redirectToRoute('hs_listing_index');
        }


        //If the request is a GET request we render the form        
        return $this->render('HSListingBundle:Listing:add.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
