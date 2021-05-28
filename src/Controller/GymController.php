<?php

namespace App\Controller;

use App\Entity\Gym;
use App\Entity\Produit;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class GymController extends AbstractController
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
     * @Route("/gymsTable", name="gymsTable")
     */
    public function gymsTable(): Response
    {
        $product = $this->getDoctrine()
            ->getRepository(Gym::class)->findAll();
        return $this->render('admin/gymTable.html.twig', [
            'controller_name' => 'AdminController',
            'data'=>$product,
            'error'=>-1
        ]);
    }

    /**
     * @Route("/gyms/all", name="gymsAll")
     */
    public function gymsAll(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT p FROM App\Entity\Gym p');
        $p = $query->getArrayResult();

        $response = new Response(json_encode($p));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
    /**
     * @Route("/gyms/search/{s}", name="gymsSearch")
     */
    public function gymsSearch(String $s): Response
    {
        $em = $this->getDoctrine()->getManager();
        $result = $em->getRepository(Gym::class)->createQueryBuilder('o')
            ->where('o.id = :id')
            ->orWhere('o.nom LIKE :product')
            ->setParameter('id', $s)
            ->setParameter('product', '%'.$s.'%')
            ->getQuery()
            ->getArrayResult();

        $response = new Response(json_encode($result));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/gyms/new", name="gymsNew")
     */
    public function productsNew(): Response
    {
        return $this->render('admin/gymsNew.html.twig', [
            'controller_name' => 'AdminController',
            'error' => '-1',
        ]);
    }
    /**
     * @Route("/gyms/submit", name="gymsSubmit")
     * @param $request
     */
    public function gymsSubmit(Request $request): Response
    {
        $nom = $request->get('nom');
        $zone = $request->get('zone');
        $adresse = $request->get('adresse');
        $num = $request->get('num');
        $lat = $request->get('lat');
        $lon = $request->get('lon');

        if($nom=="" or $zone=="" or $adresse=="" or $num=="")
            return $this->render('admin/gymsNew.html.twig', [
                'controller_name' => 'AdminController',
                'error' => '1',
            ]);
        else{
            $entityManager = $this->getDoctrine()->getManager();

            $p = new Gym();
            $p->setNom($nom);
            $p->setzone($zone);
            $p->setAdresse($adresse);
            $p->setNum($num);
            $p->setLat($lat);
            $p->setLon($lon);
            $entityManager->persist($p);

            $entityManager->flush();
            return $this->render('admin/gymsNew.html.twig', [
                'controller_name' => 'AdminController',
                'error' => '0'
            ]);


        }



    }


    /**
     * @Route("/gyms/submitEdit", name="gymsSubmitEdit")
     * @param $request
     */
    public function gymsSubmitEdit(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Gym::class)->find($request->get('id'));

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '
            );
        }

        $product->setNom($request->get('nom'));
        $product->setzone($request->get('zone'));
        $product->setAdresse($request->get('adresse'));
        $product->setNum($request->get('num'));
        $product->setLat($request->get('lat'));
        $product->setLon($request->get('lon'));

        $entityManager->flush();

        return $this->redirectToRoute('gymsTable', [
            'id' => $product->getId()
        ]);



    }

    /**
     * @Route("/gyms/edit/{id}", name="gymsEdit")
     */
    public function gymsEdit(int $id): Response
    {
        $product = $this->getDoctrine()
            ->getRepository(Gym::class)->find($id);
        return $this->render('admin/gymsEdit.html.twig', [
            'controller_name' => 'AdminController',
            'entity'=>$product,
            'error'=>-1,
        ]);
    }

    /**
     * @Route("/gyms/delete/{id}", name="gymsDelete")
     */
    public function productsDelete(int $id): Response
    {
        try{
        $entityManager = $this->getDoctrine()->getManager();
        $product = $this->getDoctrine()
            ->getRepository(Gym::class)->find($id);
        $entityManager->remove($product);
        $entityManager->flush();
        //return $this->redirectToRoute('gymsTable', []);
            $product = $this->getDoctrine()
                ->getRepository(Gym::class)->findAll();
            return $this->render('admin/gymTable.html.twig', [
                'controller_name' => 'AdminController',
                'data'=>$product,
                'error'=>"-1"
            ]);
        }catch (\Exception $e){
            $product = $this->getDoctrine()
                ->getRepository(Gym::class)->findAll();
            return $this->render('admin/gymTable.html.twig', [
                'controller_name' => 'AdminController',
                'data'=>$product,
                'error'=>"2"
            ]);
        }
    }
}
