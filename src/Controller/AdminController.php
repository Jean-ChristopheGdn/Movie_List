<?php

namespace App\Controller;

use App\Entity\Users;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\EditUserType;
use App\Form\UsersType;



/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/users", name="users")
     */
    public function users()
    {
        $users = $this->getDoctrine()->getRepository(Users::class)->findAll();

        return $this->render('admin/users.html.twig', [
            'users' => $users
        ]);
    }
            /**
     * @Route("/user/show/{id}", name="show_user", methods={"GET"})
     */
    public function show(Users $user)
    {
        return $this->render('admin/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/user/edit/{id}", name="edit_user")
     */
    public function editUser(Users $user, Request $request)
    {
        // , UserPasswordEncoderInterface $passwordEncoder
      $form = $this->createForm(EditUserType::class, $user);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();
        // $user->setPassword(
        //     $passwordEncoder->encodePassword(
        //         $user,
        //          $form->get('plainPassword')->getData()
            ;

        $this->addFlash('message', 'User edited!');
        return $this->redirectToRoute('admin_users');
      }
      return $this->render('admin/edituser.html.twig', [
        'userForm' => $form->createView()
      ]);
    }
        /**
     * @Route("/user/new", name="new_user", methods={"GET","POST"})
     */
    public function new(Request $request)
    {
        $user = new Users();
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('message', 'User created!');
            return $this->redirectToRoute('admin_index');
        }

        return $this->render('admin/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }


        /**
     * @Route("/user/delete/{id}", name="delete_user", methods={"DELETE"})
     */
    public function delete(Request $request, Users $user)
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_index');
    }
    
    
}
