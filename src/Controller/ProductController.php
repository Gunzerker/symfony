<?php

namespace App\Controller;

use App\Entity\Produit;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ProductController extends AbstractController
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
     * @Route("/products/all", name="productsAll")
     */
    public function productsAll(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT p FROM App\Entity\Produit p');
        $p = $query->getArrayResult();

        $response = new Response(json_encode($p));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
    /**
     * @Route("/products/search/{s}", name="productsSearch")
     */
    public function productsSearch(String $s): Response
    {
        $em = $this->getDoctrine()->getManager();
        $result = $em->getRepository(Produit::class)->createQueryBuilder('o')
            ->where('o.id = :id')
            ->orWhere('o.nom LIKE :product')
            ->orWhere('o.des LIKE :product')
            ->setParameter('id', $s)
            ->setParameter('product', '%'.$s.'%')
            ->getQuery()
            ->getArrayResult();

        $response = new Response(json_encode($result));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
    /**
     * @Route("/products/new", name="productsNew")
     */
    public function productsNew(): Response
    {
        return $this->render('admin/productsNew.html.twig', [
            'controller_name' => 'AdminController',
            'error' => '-1',
        ]);
    }
    /**
     * @Route("/products/qr/{x}", name="qrCode")
     */
    public function qrCode(int $x): Response
    {
        /*$y;
        $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
        $originalFilename = pathinfo($y->getClientOriginalName(), PATHINFO_FILENAME);
        $newFilename = $originalFilename.'-'.uniqid().'.'.$y->guessExtension();
        $x->move(
            $destination,
            $newFilename
        );
        $y->setImage($newFilename);*/
        return $this->render('admin/qr.html.twig', [
            'controller_name' => 'AdminController',
            'code' => $x,
        ]);
    }

    /**
     * @Route("/products/submit", name="productsSubmit")
     * @param $request
     */
    public function productsSubmit(Request $request): Response
    {
        $nom = $request->get('nom');
        $des = $request->get('des');
        $prix = $request->get('prix');
        $img = $request->get('image');
        if($nom=="" or $prix <= 0)
            return $this->render('admin/productsNew.html.twig', [
                'controller_name' => 'AdminController',
                'error' => '1',
            ]);
        else{




            $entityManager = $this->getDoctrine()->getManager();

            $p = new Produit();
            $p->setNom($nom);
            $p->setDes($des);
            $p->setPrix($prix);
            //$p->setImage($img);
            $p->setModby(1);
            $p->setLastmod(\DateTime::createFromFormat('d/m/Y', date("d/m/Y")));



            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $img->getData();
            if ($uploadedFile){
                $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();
                $uploadedFile->move(
                    $destination,
                    $newFilename
                );
                $p->setImage($newFilename);
            }else{

            }

            $entityManager->persist($p);
            $entityManager->flush();
            return $this->render('admin/productsNew.html.twig', [
                'controller_name' => 'AdminController',
                'error' => '0'
            ]);


        }



    }


    /**
     * @Route("/products/submitEdit", name="productsSubmitEdit")
     * @param $request
     */
    public function productsSubmitEdit(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Produit::class)->find($request->get('id'));

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '
            );
        }

        $product->setNom($request->get('nom'));
        $product->setDes($request->get('des'));
        $product->setPrix($request->get('prix'));
        $product->setImage($request->get('image'));

        $entityManager->flush();

        return $this->redirectToRoute('productsTable', [
            'id' => $product->getId()
        ]);



    }

    /**
     * @Route("/products/edit/{id}", name="productsEdit")
     */
    public function productsEdit(int $id): Response
    {
        $product = $this->getDoctrine()
            ->getRepository(Produit::class)->find($id);
        return $this->render('admin/productsEdit.html.twig', [
            'controller_name' => 'AdminController',
            'entity'=>$product,
        ]);
    }

    /**
     * @Route("/products/delete/{id}", name="productsDelete")
     */
    public function productsDelete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $this->getDoctrine()
            ->getRepository(Produit::class)->find($id);
        $entityManager->remove($product);
        $entityManager->flush();
        return $this->redirectToRoute('productsTable', []);
    }
}
