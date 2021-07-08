<?php
/**
 * Created by PhpStorm.
 * User: Redaa
 * Date: 2/1/2018
 * Time: 4:16 PM
 */

namespace HS\ListingBundle\EventListener;


use HS\ListingBundle\Event\Listing\ListingPostCreatedEvent;
use HS\ListingBundle\Event\Listing\ListingPreCreatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class ListingSubscriber implements EventSubscriberInterface
{

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2')))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return array(
            ListingPostCreatedEvent::NAME => 'onPostListingCreated',
            ListingPreCreatedEvent::NAME => 'onPreListingCreated'
        );
    }


    public function onPostListingCreated($event) {
        //var_dump($event->getListing()->getName());
        //die;
    }

    public function onPreListingCreated($event) {
        //var_dump($event->getListing());
        //die;
    }
}