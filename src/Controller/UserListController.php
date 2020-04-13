<?php

namespace App\Controller;

use App\Entity\UserList;
use App\Form\UserListType;
use App\Entity\Users;
use App\Repository\UserListRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profile/user/list")
 */
class UserListController extends AbstractController
{
    /**
     * @Route("/", name="user_list_index", methods={"GET"})
     */
    public function index(UserListRepository $userListRepository): Response
    {
        return $this->render('user_list/index.html.twig', [
            'user_lists' => $userListRepository->findAll(),
        ]);
    }


    /**
     * @Route("/new", name="user_list_new")
     */
    public function new(Request $request)
    {
        $userList = new UserList();

        $form = $this->createForm(UserListType::class, $userList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          $this->denyAccessUnlessGranted('ROLE_USER');
          $userList->setUsers($this->getUser());
          $userList->setCreatedAt(new \DateTime('now'));
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($userList);
          $entityManager->flush();

          return $this->redirectToRoute('user_list_index');
        }

        return $this->render('user_list/new.html.twig', [
            'user_list' => $userList,
            'listForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_list_show", methods={"GET"})
     */
    public function show(UserList $userList): Response
    {
        return $this->render('user_list/show.html.twig', [
            'user_list' => $userList,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_list_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UserList $userList): Response
    {
        $form = $this->createForm(UserListType::class, $userList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_list_index');
        }

        return $this->render('user_list/edit.html.twig', [
            'user_list' => $userList,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_list_delete", methods={"DELETE"})
     */
    public function delete(Request $request, UserList $userList): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userList->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($userList);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_list_index');
    }
}
