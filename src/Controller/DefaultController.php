<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    public function index() : JsonResponse
    {
        return new JsonResponse(['message'=>'hi']);
    }
}
