<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Product;
use App\Form\SearchType;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    /**
     * @Route("/nos-produits", name="products")
     */
    public function index(ProductRepository $products, Request $request): Response
    {
        //peut aussi se faire comme ca pour récuperer tous les products
        $em = $this->getDoctrine()->getManager();
       

        $search = new Search;
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);
        if( $form->isSubmitted() && $form->isValid()) {
            // dd($search);
            $products = $em->getRepository(Product::class)->findWithSearch($search);
        } else {
             $products = $em->getRepository(Product::class)->findAll();
        }

        return $this->render('product/index.html.twig', [
            //'products' => $products->findAll(),
            'products' => $products,
            'form' => $form->createView(),
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
