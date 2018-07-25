<?php

namespace App\Tests\Controller;

use App\Controller\PagSeguroController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PagSeguroControllerTest extends WebTestCase
{

    public function testGetSessionId()
    {
        $client = static::createClient();

        $client->request('GET', '/pagseguro/session');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

}
