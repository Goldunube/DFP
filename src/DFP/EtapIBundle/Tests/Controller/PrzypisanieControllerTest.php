<?php

namespace DFP\EtapIBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PrzypisanieControllerTest extends WebTestCase
{
    public function testPrzedluzprzypisanie()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/PrzedluzPrzypisanie');
    }

}
