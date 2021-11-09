<?php

namespace App\Classe;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;



class Cart
{
    private $session;
    private $entityManager;
    public function __construct(SessionInterface $session, EntityManagerInterface $entityManager){
        $this->session = $session;
        $this->entityManager = $entityManager;
    }

    /**
     * fonction pour récupérer la totalité du panier
    */
    public function getFull(){
    
        $cartComplete = [];
        //si il y a un panier, tu foreach dedans pour afficher les produits
        if($this->get()){

            foreach ($this->get() as $id => $quantity){
                $product_object =  $this->entityManager->getRepository(Product::class)->findOneBy(['id' => $id]);
                //je vérifie que l'id correpond a un produit sinon je le supprime du panier
                if(!$product_object){
                    $this->delete($id);
                    continue;
                }

                $cartComplete[] = [
                    'product' => $product_object,
                    'quantity' => $quantity
                ];
            }
        }
        return $cartComplete;
    }

    /**
     * fonction pour ajouter un produit dans le panier
    */
    public function add($id)
    {
        $cart = $this->session->get('cart', []);
        if(!empty($cart[$id])){
            $cart[$id] ++;
        } else {
            $cart[$id] = 1;
        }

        $this->session->set('cart', $cart);
    }

    /**
     * fonction pour récuperer le panier
    */
    public function get(){
        return $this->session->get('cart');
    }

    /**
     * fonction pour supprimer le panier
    */
    public function remove(){
        return $this->session->remove('cart');
    }

    /**
     * fonction pour supprimer un produit du panier
    */
    public function delete($id){

        $cart = $this->session->get('cart');
        unset($cart[$id]);
        return $this->session->set('cart', $cart);
    }

    /**
     * fonction pour supprimer une quantité d'un produit du panier
    */
    public function decrease($id){
      $cart = $this->session->get('cart');  
      if($cart[$id] > 1){
        $cart[$id] --;
      } else {
        unset($cart[$id]);
      }
      return $this->session->set('cart', $cart);

    }



}