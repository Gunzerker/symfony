<?php

namespace App\Controller;

use App\Entity\Produit;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class AdminController extends AbstractController
{
    /**
     * @Route("/adminIndex", name="adminIndex")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    /**
     * @Route("/productsTable", name="productsTable")
     */
    public function productsTable(): Response
    {
        $product = $this->getDoctrine()
            ->getRepository(Produit::class)->findAll();
        return $this->render('admin/productsTable.html.twig', [
            'controller_name' => 'AdminController',
            'data'=>$product,
        ]);
    }

    /**
     * @Route("/userDataTable", name="userDataTable")
     */
    public function userDataTable(): Response
    {
        return $this->render('admin/data.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/userDataChart", name="userDataChart")
     */
    public function userDataChart(): Response
    {
        return $this->render('admin/userDataChart.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
  

}
