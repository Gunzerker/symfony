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
        $rawQuery1 = 'SELECT p.* ,g.nom as gnom,g.id as gid, s.qte FROM gym as g , produit as p , stock as s WHERE g.id = s.id_gym_id and p.id = s.id_produit_id and s.id_gym_id = :gid and p.nom LIKE :np;';


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
            $rawQuery1 = 'SELECT p.* ,g.nom as gnom,g.id as gid, s.qte FROM gym as g , produit as p , stock as s WHERE g.id = s.id_gym_id and p.id = s.id_produit_id ;';


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


}
