<?php
/**
 * Created by PhpStorm.
 * User: Redaa
 * Date: 2/1/2018
 * Time: 5:35 PM
 */

namespace HS\ListingBundle\Controller\Order;


use Doctrine\Common\Collections\ArrayCollection;
use HS\ListingBundle\Entity\Listing;
use HS\ListingBundle\Entity\LOrder;
use HS\ListingBundle\Event\Order\OrderCreatedEvent;
use HS\ListingBundle\Repository\LOrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class OrderController extends Controller
{

    /**
     *
     * @Route("/listing/{id}/order", name="hs_listing_order_new")
     * @Security("listing.getActive() == true && has_role('ROLE_USER')")
     */
    public function placeOrder (Listing $listing) {



        return $this->render('HSListingBundle:Order:new.html.twig', array(
            'listing' => $listing
        ));
    }

    /**
     *
     * @Route("/listing/{id}/order/create", name="hs_listing_order_create")
     * @Security("listing.getActive() == true && has_role('ROLE_USER')")
     */
    public function placeOrderConfirm (Listing $listing, LOrderRepository $orderRepository) {

        //construct the other
        //TODO move this elsewhere
        $listings = new ArrayCollection();
        $listings->add($listing);
        $order = new LOrder($listings, $this->getUser());
        $order = $orderRepository->addOrder($order);


        $eventDispatcher = $this->get("event_dispatcher");
        $eventDispatcher->dispatch(OrderCreatedEvent::NAME, new OrderCreatedEvent( $order));

        return $this->render('HSListingBundle:Order:view.html.twig', array(
            'order' => $order
        ));
    }

}