<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CardRepository")
 */
class Card
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
     * @ORM\Column(type="integer")
     */
    private $cost;

    /**
     * @ORM\Column(type="integer")
     */
    private $attack;

    /**
     * @ORM\Column(type="integer")
     */
    private $HP;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Type", inversedBy="cards")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="cards")
     */
    private $user_card;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $img;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Deck", mappedBy="cardDecks")
     */
    private $decks;

    public function __construct()
    {
        $this->decks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getcost(): ?string
    {
        return $this->cost;
    }

    public function setcost(string $cost): self
    {
        $this->cost = $cost;

        return $this;
    }

    public function getAttack(): ?int
    {
        return $this->attack;
    }

    public function setAttack(int $attack): self
    {
        $this->attack = $attack;

        return $this;
    }

    public function getHP(): ?int
    {
        return $this->HP;
    }

    public function setHP(int $HP): self
    {
        $this->HP = $HP;

        return $this;
    }

    public function gettype(): ?type
    {
        return $this->type;
    }

    public function settype(?type $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getUserCard(): ?User
    {
        return $this->user_card;
    }

    public function setUserCard(?User $user_card): self
    {
        $this->user_card = $user_card;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): self
    {
        $this->img = $img;

        return $this;
    }

    /**
     * @return Collection|Deck[]
     */
    public function getDecks(): Collection
    {
        return $this->decks;
    }

    public function addDeck(Deck $deck): self
    {
        if (!$this->decks->contains($deck)) {
            $this->decks[] = $deck;
            $deck->addCardt($this);
        }

        return $this;
    }

    public function removeDeck(Deck $deck): self
    {
        if ($this->decks->contains($deck)) {
            $this->decks->removeElement($deck);
            $deck->removeCardt($this);
        }

        return $this;
    }
}
