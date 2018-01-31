<?php

namespace HS\ListingBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* 
*/
class ControllerEventSubscriber 
{
	
    private $hs_file_mover;

    private $publicDirectory;

	
/*
   public function onKernelRequest(GetResponseEvent $event)
    {  
        $request = $event->getRequest();
        //checkif request contains file
        try {
            if ($request->getPhoto() != ) {
                var_dump($request->getListing()getPhoto());


                /*$files = $request->files;
                foreach ($files as $file) {
                    var_dump($file);
                    $this->hs_file_mover->moveFile($file)
                }
                die;
            }
        } catch (Exception ex) {

        }
        
    } 

    /**
     * Dependency Injection on fileMover
     * @param type $fileMover 
     * @return type
     
    public function setHsFileMover($fileMover)
    {
        $this->hs_file_mover = $fileMover;
    }

    public function setPublicDirectory($dir)
    {
        $this->publicDirectory = $dir;
    }
   
    /**
     * @return array
     
    public static function getSubscribedEvents()
    {
        //we subscribe to events using the services.yml file
        return array();
    }
    */
}