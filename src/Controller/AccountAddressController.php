<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountAddressController extends AbstractController
{
    /**
     * @Route("/compte/adresses", name="account_address")
     */
    public function index(): Response
    {
        return $this->render('account/address.html.twig');
    }

    /**
     * @Route("/compte/ajouter-une-adresse", name="account_address_add")
     */
    public function add(Request $request): Response
    {
        $adresse = new Address;
        $form = $this->createForm(AddressType::class, $adresse);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $adresse = $form->getData();
            $adresse->setUser($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($adresse);
            $em->flush();

            return $this->redirectToRoute('account_address');
        }

        return $this->render('account/address_add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/compte/modifier-une-adresse/{id}", name="account_address_edit")
     */
    public function edit(Request $request, $id, AddressRepository $addressRepo): Response
    {
        $adresse = $addressRepo->findOneBy(array('id' => $id));
        //je vérifie si l'adresse existe et si l'adresse apartient bien au user connécté
        if(!$adresse || $adresse->getUser() != $this->getUser()){
            return $this->redirectToRoute('account_address');
        }
        $form = $this->createForm(AddressType::class, $adresse);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $adresse = $form->getData();
            $adresse->setUser($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('account_address');
        }

        return $this->render('account/address_edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/compte/supprimer-une-adresse/{id}", name="account_address_delete")
     */
    public function delete(EntityManagerInterface $entityManager, $id)
    {
        $adresse = $entityManager->getRepository(Address::class)->findOneById($id);
      
        if($adresse && $adresse->getUser() == $this->getUser()){
           $entityManager->remove($adresse);
           $entityManager->flush();
            
        }


        return $this->redirectToRoute('account_address');
    }



}
