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

        return $this->render('layout/index.html.twig', [
            'controller_name' => 'CardController',
            'entities' => $entities,
            'title' => 'liste des cartes',
        ]);
    }

    /**
     * @Route("/create_card", name="create_card")
     */
    public function createCard(Request $request)
    {

        $card = new Card();
        $form = $this->createForm(CardType::class, $card);
        
        // $cards = $this->em->getRepository(Card::class)->findAll();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $this->getUser();
            $card->setIdCreator($user);

            $img = $form->get('img')->getData();
            if (!empty($img) || $img != null ) {
                $imageName = 'card-'.uniqid().'.'.$img->guessExtension();
                $img->move(
                    $this->getParameter('cards_folder'),
                    $imageName
                );
            }
            else 
            {
                $imageName = 'card.png';
            }

            $card->setImg($imageName);
            

            $this->em->persist($card);

            $this->em->flush();
            

            return $this->redirectToRoute('card');

        }
        return $this->render('layout/form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Création de carte',
        ]);
    }
     /**
     * @Route("/card/{id}", name="card_delete")
     */
    public function delete(Request $request, Card $card)
    {
        if ($this->isCsrfTokenValid('delete'.$card->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($card);
            $em->flush();
        }

        return $this->redirectToRoute('card');
    }
}
