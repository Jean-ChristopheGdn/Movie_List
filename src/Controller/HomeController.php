<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Users;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {   
        $user = $this->getDoctrine()->getRepository(Users::class)->findAll();
        
        return $this->render('home/index.html.twig', ['user' => $user,
            'controller_name' => 'HomeController',
        ]);
    
    }

}
