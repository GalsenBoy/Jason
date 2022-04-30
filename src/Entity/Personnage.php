<?php

namespace App\Entity;

use App\Repository\PersonnageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonnageRepository::class)]
class Personnage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $membre;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMembre(): ?string
    {
        return $this->membre;
    }

    public function setMembre(string $membre): self
    {
        $this->membre = $membre;

        return $this;
    }
}
