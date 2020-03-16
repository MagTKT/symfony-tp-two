<?php

namespace App\Controller;

use App\Entity\Deckcard;
use App\Entity\Card;
use App\Entity\Deck;
use App\Repository\DeckcardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;

class DeckcardController extends AbstractController
{
    /**
     * @Route("/deckcard", name="deckcard")
     */
    public function index()
    {
        return $this->render('layout/index.html.twig', [
            'controller_name' => 'DeckcardController',
        ]);
    }

    /**
 * @Route("/adddeckcard/{card}/{deck}", name="add_deckcard")
 */
    public function addDeckcard(Card $card, Deck $deck)
    {

        $deckcard = new Deckcard();

        $deckcard->setCard($card);
        $deckcard->setDeck($deck);

        $this->em->persist($deckcard);
        $this->em->flush();

        return $this->render('layout/form.html.twig', [
            'title' => 'test',
            'label' => 'test'
        ]);
    }

    /**
     * @Route("/deletedeckdard/{deckcard}", name="Deck_carddelete")
     */
    public function deleteCardDeck( int $deckCard)
    {
        $cardDeck = $this->DeckCardRepository->findOneBy(['id'=>$deckcard]);

        if ($deckcard) {
            $this->em->remove($deckcard);
            $this->em->flush();
        }
        return $this->redirectToRoute('deckcard');
    }
}

