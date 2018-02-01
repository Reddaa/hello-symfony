<?php
/**
 * Created by PhpStorm.
 * User: Redaa
 * Date: 2/1/2018
 * Time: 10:28 AM
 */

namespace HS\ListingBundle\Tests\Service;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class HSFileMoverTest extends WebTestCase
{

    private $hs_file_mover_mock;

    private $test_file;

    private $destinationDir;

    protected function setUp()
    {
        $kernel = self::bootKernel();
        $this->createMock("test");
        $this->hs_file_mover_mock = $kernel->getContainer()->get("hs_file_mover");

        $this->destinationDir = $kernel->getContainer()->getParameter("public_directory");
        $this->destinationDir = str_replace("\\", "/", $this->destinationDir);
        $this->destinationDir .= "/";
        file_put_contents("C:\photos\\test_img.png", "test");
        $this->test_file = new UploadedFile("C:\photos\\test_img.png", "test_img.png"
            , null, 1855, null, true);

    }

    public function testHSFileMoverSameExtentionAfterUpload() {
        //$res = $this->test_file->move($new_name, "C:\Users\Redaa\Documents\HiddenFounders\php_projects\hello-symfony/web/uploads/listings_images/");
        //dump("move manually: " .$res);

        $extention = $this->test_file->guessExtension();
        $newFile = $this->hs_file_mover_mock->moveFile($this->test_file);

        $file = new File($this->destinationDir  . $newFile);

        $this->assertEquals($extention, $file->guessExtension());
    }

    public function testHSFileMoverFileIsMoved(){
        $this->assertEquals(1, 1);
        $newFile = $this->hs_file_mover_mock->moveFile($this->test_file);

        $this->assertEquals(file_exists($this->destinationDir . $newFile),true);
    }
}