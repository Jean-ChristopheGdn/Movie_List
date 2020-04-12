<?php

namespace App\Controller;


use App\Entity\Users;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\EditProfileType;
use Symfony\Component\Security\Core\User\UserInterface;



/**
     * @Route("/profile", name="profile_")
     */

class ProfileController extends AbstractController
{


     /**
     * @Route("/", name="index")
     */
    public function index(Request $request, UserInterface $user)
    {
        
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'user' => $user
        ]);
    }
        /**
     * @Route("/user", name="user")
     */
    public function user()
    {
        $user = $this->getDoctrine()->getRepository(Users::class)->findAll();

        return $this->render('profile/user.html.twig', [
            'user' => $user
        ]);
    }
        /**
     * @Route("/editprofile/{id}", name="edit_user")
     */
    public function editProfile(Users $user, Request $request)
    {
      $form = $this->createForm(EditProfileType::class, $user);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        $this->addFlash('message', 'User edited!');
        return $this->redirectToRoute('profile_edit_user');
      }
      return $this->render('profile/editprofile.html.twig', [
        'userForm' => $form->createView()
      ]);
    }
    

}
