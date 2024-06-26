<?php   

// src/Entity/Book.php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: "App\Repository\BookRepository")]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private $id;

    #[ORM\Column(type: "string", length: 255)]
    private $title;

    #[ORM\ManyToMany(targetEntity: "App\Entity\Author")]
    private $authors;

    public function __construct()
    {
        $this->authors = new ArrayCollection();
    }

    // getters and setters...
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
    
    public function getAuthors(): Collection
    {
        return $this->authors;
    }
    public function addAuthor(Author $author): self
    {
        if (!$this->authors->contains($author)) {
            $this->authors[] = $author;
        }
        return $this;
    }
    public function removeAuthor(Author $author): self
    {
        $this->authors->removeElement($author);
        return $this;
    }
    public function __toString(): string
    {
        return $this->title;
    }
    
}
?>