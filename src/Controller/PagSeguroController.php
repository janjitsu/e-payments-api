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

    public function getSessionId() : JsonResponse
    {
        try {
            $sessionCode = PagSeguroSession::create(
                PagSeguroConfigure::getAccountCredentials()
            );

            return new JsonResponse(['sessionId' => $sessionCode->getResult()]);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}
