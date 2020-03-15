<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DeckController extends AbstractController
{
    private $deckRepository;
    private $em;

    public function __construct(
        DeckRepository $deckRepository,
        EntityManagerInterface $em
    ) {
        $this->deckRepository = $deckRepository;
        $this->em = $em;
    }
    /**
     * @Route("/deck", name="deck")
     */
    public function index()
    {
        $decks = $this->deckRepository->findAll();

        return $this->render('layout/index.html.twig', [
            'controller_name' => 'DeckController',
            'decks' => $decks,
            'title' => 'liste des decks',
        ]);
    }

    /**
     * @Route("/create_deck", name="create_deck")
     */
    public function createDeck(Request $request)
    {

        $deck = new Deck();
        $form = $this->createForm(DeckType::class, $deck);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em = $this->getDoctrine()->getManager();
        
            $this->em->persist($deck);

            $this->em->flush();
            

            return $this->redirectToRoute('deck');

        }
        return $this->render('layout/form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Création de deck',
        ]);
    }
}
