<?php
/**
 * Created by PhpStorm.
 * User: Redaa
 * Date: 2/2/2018
 * Time: 9:58 AM
 */

namespace HS\ListingBundle\EventListener;


use HS\ListingBundle\Event\Order\OrderCreatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class OrderListener implements EventSubscriberInterface
{

    public static function onOrderCreated() {
    }

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
            OrderCreatedEvent::NAME => 'onOrderCreated'
        );
    }
}