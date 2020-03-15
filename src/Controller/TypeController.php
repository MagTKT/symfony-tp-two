<?php

namespace App\Controller;

use App\Entity\Type;
use App\Form\TypeFormType;
use App\Repository\TypeRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class TypeController extends AbstractController
{
    private $TypeRepository;
    private $em;

    public function __construct(
        TypeRepository $TypeRepository,
        EntityManagerInterface $em
    ) {
        $this->TypeRepository = $TypeRepository;
        $this->em = $em;
    }
    /**
     * @Route("/type", name="type")
     */
    public function index()
    {
        $types = $this->TypeRepository->findAll();

        return $this->render('layout/index.html.twig', [
            'controller_name' => 'CardController',
            'types' => $types,
            'title' => 'liste des genres',
        ]);
    }

    /**
     * @Route("/create_type", name="create_type")
     */
    public function createType(Request $request)
    {

        $type = new Type();
        $form = $this->createForm(TypeFormType::class, $type);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em = $this->getDoctrine()->getManager();
            
            $this->em->persist($type);

            $this->em->flush();
            

            return $this->redirectToRoute('type');

        }
        return $this->render('layout/form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Création de genre',
        ]);
    }
}

