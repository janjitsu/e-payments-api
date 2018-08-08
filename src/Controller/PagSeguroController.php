<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use PagSeguro\Library as PagSeguroLibrary;
use PagSeguro\Services\Session as PagSeguroSession;
use PagSeguro\Configuration\Configure as PagSeguroConfigure;

class PagSeguroController extends Controller
{
    public function __construct()
    {
        PagSeguroLibrary::initialize();
        PagSeguroLibrary::cmsVersion()->setName("Nome")->setRelease("1.0.0");
        PagSeguroLibrary::moduleVersion()->setName("Nome")->setRelease("1.0.0");
    }

    /*
     *path: /pagseguro/session
     */
    public function getSessionId() : JsonResponse
    {
        try {
            $sessionCode = PagSeguroSession::create(
                PagSeguroConfigure::getAccountCredentials()
            );

            return new JsonResponse(['sessionId' => $sessionCode->getResult()]);
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()],400);
        }
    }

    /**
     *path: /pagseguro/payment
     **/
    public function postPayment()
    {
        //gather fields and post to pagseguro
    }
}
