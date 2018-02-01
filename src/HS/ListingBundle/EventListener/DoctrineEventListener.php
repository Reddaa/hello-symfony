<?php

namespace HS\ListingBundle\EventListener;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use HS\ListingBundle\Service\FileMover;
use HS\ListingBundle\Entity\Listing;

class DoctrineEventListener
{
    private $uploader;

    public function __construct(FileMover $uploader)
    {
        $this->uploader = $uploader;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    private function uploadFile($entity)
    {
        //TODO Normally every entity we create should extend an interface that forces it to implemet getFiles()
        //$file is the temp path
    	if (!$entity instanceof Listing)
    		return;

        $file = $entity->getPhoto();

        // only upload new files
        if ($file instanceof UploadedFile) {
            $fileName = $this->uploader->moveFile($file);
            $entity->setPhoto($fileName);
        }
    }
}

