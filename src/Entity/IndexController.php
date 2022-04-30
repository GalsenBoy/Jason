<?php

namespace App\Entity;

use App\Repository\IndexControllerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IndexControllerRepository::class)]
class IndexController
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private $personnage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPersonnage(): ?string
    {
        return $this->personnage;
    }

    public function setPersonnage(string $personnage): self
    {
        $this->personnage = $personnage;

        return $this;
    }
}
