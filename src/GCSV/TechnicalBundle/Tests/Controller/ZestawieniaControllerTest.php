<?php

namespace GCSV\TechnicalBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ZestawieniaControllerTest extends WebTestCase
{
    public function testShowzestawieniepracdt()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/zestawienie-prac-dt');
    }

}
