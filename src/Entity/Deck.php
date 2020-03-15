<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DecksRepository")
 */
class Decks
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CardDeck", mappedBy="decks", orphanRemoval=true)
     */
    private $cardDecks;

    public function __construct()
    {
        $this->cardDecks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->title;
    }

    public function setName(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|CardDeck[]
     */
    public function getCardDecks(): Collection
    {
        return $this->cardDecks;
    }

    public function addCardDeck(CardDeck $cardDeck): self
    {
        if (!$this->cardDecks->contains($cardDeck)) {
            $this->cardDecks[] = $cardDeck;
            $cardDeck->setIdDeck($this);
        }

        return $this;
    }

    public function removeCardDeck(CardDeck $cardDeck): self
    {
        if ($this->cardDecks->contains($cardDeck)) {
            $this->cardDecks->removeElement($cardDeck);
            // set the owning side to null (unless already changed)
            if ($cardDeck->getIdDeck() === $this) {
                $cardDeck->setIdDeck(null);
            }
        }

        return $this;
    }

}
