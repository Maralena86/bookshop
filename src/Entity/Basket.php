<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BasketRepository;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation\Timestampable;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: BasketRepository::class)]
class Basket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToMany(targetEntity: Book::class, inversedBy: 'baskets')]
    private $books;

    #[ORM\OneToOne(inversedBy: 'basket', targetEntity: User::class, cascade: ['persist', 'remove'])]
    private $user;

  
    #[Timestampable(on: 'create')]
    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): self
    {
        if (!$this->books->contains($book)) {
            $this->books[] = $book;
        }
        return $this;
    }

    public function removeBook(Book $book): self
    {
        $this->books->removeElement($book);

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }



    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
    public function totalPrice(): float
    {
        $total = 0;

        // for ($i=0; $i < count($this->books); $i++) {          
        //     $price=($this->books[$i])->getPrice();
        //     $total=$price+$total; 
        // }
        
        foreach($this->books as $book) {           
            $total=$book->getPrice()+$total;          
        }

        return $total;
    }
}
