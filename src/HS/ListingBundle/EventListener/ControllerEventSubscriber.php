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
    	var_dump($event);
    	die;
        $controller = $event->getController()[0];
        $handler = [$controller, 'onKernelController'];
        if (is_callable($handler)) {
            call_user_func($handler, $event);
        }
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
    	var_dump($event);
    	die;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => array(array('onKernelRequest', 32)),
            KernelEvents::FINISH_REQUEST => array(array('onKernelFinishRequest', 0)),
        );
    }
}