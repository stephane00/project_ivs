<?php

namespace App\Entity;

use App\Repository\PiecesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PiecesRepository::class)]
class Pieces
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $people = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Buildings $b_id = null;

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

    public function getPeople(): ?int
    {
        return $this->people;
    }

    public function setPeople(int $people): self
    {
        $this->people = $people;

        return $this;
    }

    public function getBId(): ?Buildings
    {
        return $this->b_id;
    }

    public function setBId(?Buildings $b_id): self
    {
        $this->b_id = $b_id;

        return $this;
    }
}
