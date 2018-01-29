<?php 

namespace HS\ListingBundle\Service;

/**
* 
*/
class FileMover
{
	
	function __construct()
	{
		
	}


	public function moveFile($file, $newPath)
	{
		
        //generate a unique file name for the uploaded image
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        //move the image from the tmp php folder to the app's public folder
        $file->move(
            $newPath,
            $fileName
        );
        
        return $fileName;
	}
}