<?php

namespace App\Entity;

use App\Repository\CodePromoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CodePromoRepository::class)]
class CodePromo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $pourcentage = null;

    #[ORM\Column(length: 255)]
    private ?string $nbr_use = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_code = null;





    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPourcentage(): ?int
    {
        return $this->pourcentage;
    }

    public function setPourcentage(int $pourcentage): static
    {
        $this->pourcentage = $pourcentage;

        return $this;
    }

    public function getNbrUse(): ?string
    {
        return $this->nbr_use;
    }

    public function setNbrUse(string $nbr_use): static
    {
        $this->nbr_use = $nbr_use;

        return $this;
    }

    public function getNomCode(): ?string
    {
        return $this->nom_code;
    }

    public function setNomCode(string $nom_code): static
    {
        $this->nom_code = $nom_code;

        return $this;
    }

    public static function factory(int $pourcentage,int $nbrUse,string $nom_code): self
    {
        $code = new self();
        $code->setPourcentage($pourcentage);
        $code->setNbrUse($nbrUse);
        $code->setNomCode($nom_code);
        return $code;
    }



   
}
