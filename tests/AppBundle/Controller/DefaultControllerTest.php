<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    /*
     *
     */
    public function testListingsIndexWithAuthenticatedUser() {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'jim',
            'PHP_AUTH_PW'   => 'azer',
        ));
        $crawler = $client->request("GET", "/manage/listings");

        //if the user doesn't match we get a 302 (redirect to / login)
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testListingsIndexWithAnonymousUser() {
        $client = static::createClient();
        $crawler = $client->request("GET", "/manage/listings");

        //if the user doesn't match we get a 302 (redirect to / login)
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testListingAddRenderForm() {
        $client = $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'jim',
            'PHP_AUTH_PW'   => 'azer',
        ));
        $crawler = $client->request("GET", "/manage/listing");
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testListingAdd() {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'jim',
            'PHP_AUTH_PW'   => 'azer'
        ));
        $crawler = $client->request("GET", "/manage/listing");
        $buttonCrawlerMode = $crawler->selectButton('hs_listingbundle_listing_save');
        //$this->assertEquals(200, $client->getResponse()->getContent());
        $form = $buttonCrawlerMode->form();
        $form['hs_listingbundle_listing[name]'] = "iphoneXXX";
        $form['hs_listingbundle_listing[size]'] = "158x589";
        $form['hs_listingbundle_listing[price]'] = 999;
        $form['hs_listingbundle_listing[category]']->select('1');

        $crawler = $client->submit($form);

        dump($client->getResponse()->getStatusCode());
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testListingDelete() {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'jim',
            'PHP_AUTH_PW'   => 'azer'
        ));
        $this->assertEquals(1, 1);
    }

}
