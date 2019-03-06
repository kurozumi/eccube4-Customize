<?php

namespace Customize\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class AaController extends Controller
{
    /**
     * @Route("/aa", name="aa")
     */
    public function index()
    {
        return $this->render('aa/index.html.twig', [
            'controller_name' => 'AaController',
        ]);
    }
}
