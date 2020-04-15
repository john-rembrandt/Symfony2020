<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Product;
use Faker;

class ProductController extends AbstractController
{
    /**
     * @Route("/product-create", name="create_product")
     */
    public function createProduct(): Response
    {
        $faker = Faker\Factory::create();
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();
        
        $product = new Product();
        $product->setName($faker->name);
        $product->setPrice($faker->randomDigitNotNull);
        //$product->setDescription('Ergonomic and stylish!');
        
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($product);
        
        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        
        //return new Response('Saved new product with id '.$product->getId());
         return $this->render('product/index.html.twig', ['id'=> $product->getId(), 'name'=> $product->getName(),
                'price'=> $product->getPrice()]);
    }
}
