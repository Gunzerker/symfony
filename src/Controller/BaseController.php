<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BaseController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index(): Response
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'BaseController',
        ]);
    }
  

    /**
     * @Route("/loginRegister", name="loginRegister")
     */
    public function loginRegister(): Response
    {
        return $this->render('loginRegister.html.twig', [
            'controller_name' => 'BaseController',
        ]);
    }

    /**
     * @Route("/modal", name="modal")
     */
    public function modala(): Response
    {
        return $this->render('modaltajrba.html.twig', [
            'controller_name' => 'BaseController',
        ]);
    }
}
