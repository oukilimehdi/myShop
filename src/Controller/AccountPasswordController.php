<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccountPasswordController extends AbstractController
{
    /**
     * @Route("/compte/modifier-mot-de-passe", name="account_password")
     */
    public function index(Request $request , UserPasswordHasherInterface $hash): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);
        $form->handleRequest($request);
        $notification = "";

        if( $form->isSubmitted() && $form->isValid()) {
            
            $old_password = $form->get('old_password')->getData();
            if($hash->isPasswordValid($user, $old_password)){
                $new_password = $hash->hashPassword($user, $form->get('new_password')->getData());
                $user->setPassword($new_password);

                $em = $this->getDoctrine()->getManager();
                $em->flush();

                $this->addFlash('mdpModifie', 'votre mot de passe a bien été modifié');
                return $this->redirectToRoute('account');

            } else {
                $notification = "votre mot de passe actuel est incorrect ";
            }

        }


        return $this->render('account/password.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }
    
}
