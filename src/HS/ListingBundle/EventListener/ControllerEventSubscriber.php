<?php

namespace HS\ListingBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* 
*/

class ControllerEventSubscriber implements EventSubscriberInterface
{
	
	/**
     * @param FilterControllerEvent $event
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController()[0];
        $handler = [$controller, 'onKernelController'];
        if (is_callable($handler)) {
            call_user_func($handler, $event);
        }
    }


    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array();
    }
}