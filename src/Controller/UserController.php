<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class UserController extends AbstractController
{
    private $UserRepository;
    private $em;

    public function __construct(UserRepository $UserRepository,EntityManagerInterface $em){
        $this->UserRepository = $UserRepository;
        $this->em = $em;
    }

    /**
     * @Route("/user", name="user")
     */
    public function listUser()
    {
        $user = $this->UserRepository->findAll();
        return $this->render('layout/index.html.twig', [
        'user' => $user,
        'title' => 'Liste des utilisateurs'        ]);
    }
}
