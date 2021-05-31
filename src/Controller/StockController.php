<?php

namespace App\Controller;

use App\Entity\Gym;
use App\Entity\Produit;
use App\Entity\Stock;
use Doctrine\ORM\Mapping\Entity;
use stdClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\Query\ResultSetMapping;

class StockController extends AbstractController
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
     * @Route("/stockTable", name="stockTable")
     */
    public function stockTable(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $s = $this->getDoctrine()
            ->getRepository(Stock::class)->findAll();

        $data = [];
        $gyms= $em
        ->getRepository(Gym::class)->findAll();
        foreach($s as $e){
            $gym = $em
                ->getRepository(Gym::class)->find($e->getIdGym());
            $produit = $em
                ->getRepository(Produit::class)->find($e->getidProduit());
            $object = new stdClass();
            $object->i = 0;
            $object->g = $gym;
            $object->p = $produit;
            $object->q = $e->getQte();

            $data[] = $object;
        }
        return $this->render('admin/stockTable.html.twig', [
            'controller_name' => 'AdminController',
            'data'=>$data,
            'gyms'=>$gyms,
        ]);
    }

    /**
     * @Route("/stock/{g}/{s}", name="stockSearch")
     */
    public function stockSearch(int $g,string $s): Response
    {
        var_dump($g);
        if($g != -1){

        // Get connections
        $DatabaseEm1 = $this->getDoctrine()->getManager();


        // Write your raw SQL
        $rawQuery1 = 'SELECT p.* ,g.nom as gnom,g.id as gid, s.qte , s.id FROM gym as g , produit as p , stock as s WHERE g.id = s.id_gym_id and p.id = s.id_produit_id and s.id_gym_id = :gid and p.nom LIKE :np;';


        // Prepare the query from DATABASE1
        $statementDB1 = $DatabaseEm1->getConnection()->prepare($rawQuery1);
        $statementDB1->bindValue('gid', $g);
        $statementDB1->bindValue('np', '%'.$s.'%');



        // Execute both queries
        $statementDB1->execute();


        // Get results :)
        $resultDatabase1 = $statementDB1->fetchAll();



        $response = new Response(json_encode($resultDatabase1));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
        }else{
// Get connections
            $DatabaseEm1 = $this->getDoctrine()->getManager();


            // Write your raw SQL
            $rawQuery1 = 'SELECT p.* ,g.nom as gnom,g.id as gid,s.qte FROM gym as g , produit as p , stock as s WHERE g.id = s.id_gym_id and p.id = s.id_produit_id and p.nom LIKE :np;';


            // Prepare the query from DATABASE1
            $statementDB1 = $DatabaseEm1->getConnection()->prepare($rawQuery1);
            $statementDB1->bindValue('np', '%'.$s.'%');



            // Execute both queries
            $statementDB1->execute();


            // Get results :)
            $resultDatabase1 = $statementDB1->fetchAll();



            $response = new Response(json_encode($resultDatabase1));
            $response->headers->set('Content-Type', 'application/json');

            return $response;

        }
    }
    /**
     * @Route("/stock/{g}", name="stockSearch2")
     */
    public function stockSearch2(int $g): Response
    {

        if($g != -1){



            // Get connections
            $DatabaseEm1 = $this->getDoctrine()->getManager();


            // Write your raw SQL
            $rawQuery1 = 'SELECT p.* ,g.nom as gnom,g.id as gid, s.qte FROM gym as g , produit as p , stock as s WHERE g.id = s.id_gym_id and p.id = s.id_produit_id and s.id_gym_id = :gid;';


            // Prepare the query from DATABASE1
            $statementDB1 = $DatabaseEm1->getConnection()->prepare($rawQuery1);
            $statementDB1->bindValue('gid', $g);




            // Execute both queries
            $statementDB1->execute();


            // Get results :)
            $resultDatabase1 = $statementDB1->fetchAll();



            $response = new Response(json_encode($resultDatabase1));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }else{
            // Get connections
            $DatabaseEm1 = $this->getDoctrine()->getManager();


            // Write your raw SQL
            $rawQuery1 = 'SELECT p.* ,g.nom as gnom,g.id as gid, s.qte , s.id as sid FROM gym as g , produit as p , stock as s WHERE g.id = s.id_gym_id and p.id = s.id_produit_id ;';


            // Prepare the query from DATABASE1
            $statementDB1 = $DatabaseEm1->getConnection()->prepare($rawQuery1);





            // Execute both queries
            $statementDB1->execute();


            // Get results :)
            $resultDatabase1 = $statementDB1->fetchAll();



            $response = new Response(json_encode($resultDatabase1));
            $response->headers->set('Content-Type', 'application/json');

            return $response;

        }
    }

    /**
     * @Route("/stocks/new", name="stocksNew")
     */
    public function stocksNew(): Response
    {
        $product = $this->getDoctrine()
            ->getRepository(Produit::class)->findAll();
        $gym = $this->getDoctrine()
            ->getRepository(Gym::class)->findAll();
        return $this->render('admin/stockNew.html.twig', [
            'controller_name' => 'AdminController',
            'product'=>$product,
            'gyms'=>$gym,
            'error' => '-1',
        ]);
    }

    /**
     * @Route("/stocks/edit/{id}", name="stocksEdit")
     */
    public function stocksEdit(int $id): Response
    {

        // Get connections
        $DatabaseEm1 = $this->getDoctrine()->getManager();


        // Write your raw SQL
        $rawQuery1 = 'SELECT p.* ,g.nom as gnom,g.id as gid, s.qte , s.id as sid FROM gym as g , produit as p , stock as s WHERE (g.id = s.id_gym_id and p.id = s.id_produit_id) and s.id = :idv ;';


        // Prepare the query from DATABASE1
        $statementDB1 = $DatabaseEm1->getConnection()->prepare($rawQuery1);

        $statementDB1->bindValue(':idv', $id);



        // Execute both queries
        $statementDB1->execute();


        // Get results :)
        $resultDatabase1 = $statementDB1->fetchAll();
        $product = $this->getDoctrine()
            ->getRepository(Produit::class)->findAll();
        $gym = $this->getDoctrine()
            ->getRepository(Gym::class)->findAll();

        return $this->render('admin/stocksEdit.html.twig', [
            'controller_name' => 'AdminController',
            'entity'=>$resultDatabase1,
            'product'=>$product,
            'gyms'=>$gym
        ]);

    }

    /**
     * @Route("/stocks/create", name="stocksCreate")
     * @param $request
     */
    public function stocksCreate(Request $request): Response
    {
        $id_gym_id = $request->get("gym_selector")+0;
        $id_produit_id = $request->get('product_selector')+0;
        $qte = $request->get('quantity')+0;

        // Get connections
        $DatabaseEm1 = $this->getDoctrine()->getManager();


        // Write your raw SQL
        $rawQuery1 = 'insert into stock (id_gym_id , id_produit_id , qte) values(:id_gym , :id_produit , :qte);';


        // Prepare the query from DATABASE1
        $statementDB1 = $DatabaseEm1->getConnection()->prepare($rawQuery1);

        $statementDB1->bindValue(':id_gym', $id_gym_id);
        $statementDB1->bindValue(':id_produit', $id_produit_id);
        $statementDB1->bindValue(':qte', $qte);



        // Execute both queries
        $statementDB1->execute();



        /** @var UploadedFile $uploadedFile */
            /*$uploadedFile = date("Y-m-d");
            if ($uploadedFile){
                $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();
                $uploadedFile->move(
                    $destination,
                    $newFilename
                );
                $p->setImage($newFilename);
            }*/


            return $this->redirectToRoute('stockTable', [
             ]);
            /*return $this->render('admin/stockTable.html.twig', [
                'controller_name' => 'AdminController',
                'error' => '0'
            ]);*/


    }


    /**
     * @Route("/stocks/delete/{id}", name="stocksDelete")
     */
    public function stocksDelete(int $id): Response
    {   try{
        $entityManager = $this->getDoctrine()->getManager();
        $product = $this->getDoctrine()
            ->getRepository(Stock::class)->find($id);
        $entityManager->remove($product);
        $entityManager->flush();
        return $this->redirectToRoute('stockTable', []);
    }catch (\Exception $e){
        $product = $this->getDoctrine()
            ->getRepository(Stock::class)->findAll();
        return $this->render('admin/stockTable.html.twig', [
            'controller_name' => 'AdminController',
            'data'=>$product,
            'error'=>"2"
        ]);
        //return $this->redirectToRoute('productsTable', ['error' => '2']);

    }
    }




}
