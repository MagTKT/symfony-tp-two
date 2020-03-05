<?php

namespace App\Controller;

use App\Entity\Card;
use App\Form\CardType;
use App\Repository\CardRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class CardController extends AbstractController
{
    private $cardRepository;
    private $em;

    public function __construct(
        CardRepository $cardRepository,
        EntityManagerInterface $em
    ) {
        $this->cardRepository = $cardRepository;
        $this->em = $em;
    }
    /**
     * @Route("/card", name="card")
     */
    public function index()
    {
        $entities = $this->cardRepository->findAll();

        return $this->render('card/index.html.twig', [
            'controller_name' => 'CardController',
            'entities' => $entities,
        ]);
    }

    /**
     * @Route("/create_card", name="create_card")
     */
    public function createCard(Request $request)
    {

        $card = new Card();
        $form = $this->createForm(CardType::class, $card);

        $cards = $em->getRepository(Card::class)->findAll();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            
            $entityManager->persist($card);

            $entityManager->flush();
            

            return $this->redirectToRoute('card');

        }
        return $this->render('card/new_card.html.twig', [
            'card' => $form->createView(),
        ]);
    }
}
