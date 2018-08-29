<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    /**
     * Show demo javascript page
     */
    public function index()
    {
        return $this->render('demo.html.twig');
    }
}
