<?php

namespace App\Controller;

use App\Entity\Deck;
use App\Form\DeckType;
use App\Repository\CardRepository;
use App\Repository\DeckRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Annotation\Route;

class DeckController extends AbstractController
{
    private $deckRepository;
    private $em;

    public function __construct(
        DeckRepository $deckRepository,
        EntityManagerInterface $em
    ) 
    {
        $this->deckRepository = $deckRepository;
        $this->em = $em;
    }

    /**
     * @Route("/listdeck", name="list_deck")
     */
    public function listDecks()
    {
        $decks = $this->deckRepository->findAll();

        return $this->render('layout/index.html.twig', [
            'decks' => $decks,
            'title' => 'liste des Decks '
        ]);
    }

    /**
     * @Route("/adddeck", name="add_deck")
     */
    public function addDeck(Request $request)
    {
        $deck = new Deck();
        $form = $this->createForm(DeckType::class, $deck);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid())
        {

            $deck->setCreator($this->getUser());

            $this->em->persist($deck);
            $this->em->flush();

        }

        return $this->render('layout/form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Deck',
            'label' => 'Creer un deck'
        ]);

    }

}



