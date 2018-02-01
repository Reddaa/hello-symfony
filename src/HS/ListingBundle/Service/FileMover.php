<?php 

namespace HS\ListingBundle\Service;

/**
* 
*/
class FileMover
{
	
	private $destination_dir;

	function __construct($destination_dir)
	{
		$this->destination_dir = $destination_dir;
	}


	public function moveFile($file)
	{
		
        //generate a unique file name for the uploaded image
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        //move the image from the tmp php folder to the app's public folder
        $file->move(
            $this->destination_dir,
            $fileName
        );
        
        return $fileName;
	}
}