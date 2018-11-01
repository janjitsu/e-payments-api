<?php

namespace App\Tests\Controller;

use App\Controller\PagSeguroController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Dotenv\Dotenv;

class PagSeguroControllerTest extends WebTestCase
{
    public static function setupBeforeClass()
    {
        $env = __DIR__.'/../Resources/.env.test';

        if (file_exists($env)) {
            (new Dotenv())->load($env);
        }
    }

    public function testGetSessionId()
    {
        $client = static::createClient();
        $client->request('GET', '/pagseguro/session');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /*
     * @todo Pass post fields to pagseguro request
     */
    public function testPostCreditCardPayment()
    {
        $client = static::createClient();
        $client->request('POST', '/pagseguro/creditCardPayment');
        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }
}
