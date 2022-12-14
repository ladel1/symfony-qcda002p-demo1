<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Le champs nom ne peut pas etre vide!")
     * @Assert\Length(min=3,max=255,
     *  minMessage="Trop court",
     *  maxMessage="Trop long"
     * )
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @Assert\Type(
     * type="float",
     * message="seulement des nombres réels"
     * )
     * @Assert\Range( min=0,max=500,
     * minMessage="min 0€",
     * maxMessage="max 500€"
     * )
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @Assert\NotBlank(groups={"Registration"})
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="articles", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category; 


    public function getId(): ?int
    {      
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
