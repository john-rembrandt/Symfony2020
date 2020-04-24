<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Product;
use App\Form\ProductType;
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
         return $this->render('product/product.html.twig', ['id'=> $product->getId(), 'name'=> $product->getName(),
                'price'=> $product->getPrice()]);
    }

    /**
     * @Route("/product-list", name="list_product")
     */
    public function listProduct(): Response
    {
        $allProduct = $this->getDoctrine()
        ->getRepository(Product::class)
        ->findAll();
        
        return $this->render('product/product.html.twig',
               array('products' => $allProduct));

    }

    /**
     * @Route("/product/{id}", name="product_show")
     */
    public function showProduct($id)
    {
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return new Response('Check out this great product: '.$product->getName());

        // or render a template
        // in the template, print things with {{ product.name }}
        // return $this->render('product/show.html.twig', ['product' => $product]);
    }

    /**
     * @Route("/productForm", name="product_form")
     */
    public function new(Request $request)
    {
        $product = new Product();
        

        $form = $this->createForm(ProductType::class, $product);

        return $this->render('product/product.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
