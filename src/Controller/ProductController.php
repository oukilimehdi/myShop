<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    /**
     * @Route("/nos-produits", name="products")
     */
    public function index(ProductRepository $products): Response
    {
        //peut aussi se faire comme ca
        // $em = $this->getDoctrine()->getManager();
        // $products = $em->getRepository(Product::class)->findAll();

        return $this->render('product/index.html.twig', [
            'products' => $products->findAll(),
        ]);
    }

    /**
     * @Route("/produit/{slug}", name="product")
     */
    public function show($slug, ProductRepository $productRepo): Response
    {
        //$product = $productRepo->findOneBySlug($slug);
        $product = $productRepo->findOneBy(["slug" => $slug]);
        if(!$product){
            return $this->redirectToRoute('products');
        }

        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

}
