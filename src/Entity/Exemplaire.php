<?php

namespace App\Entity;

use App\Repository\ExemplaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ExemplaireRepository::class)]
#[Vich\Uploadable]
class Exemplaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'exemplaires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Vehicule $vehicule = null;

    #[ORM\ManyToOne(inversedBy: 'exemplaires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $categorie = null;

    #[ORM\ManyToOne(inversedBy: 'exemplaires')]
    private ?Type $type = null;

    #[ORM\Column]
    #[Assert\Regex(
        pattern: "/[0-9]/",
        match: true,
        message: 'Le prix ne peut pas contenir des lettres et/ou des caractères spéciaux',
    )]
    private ?int $prix = null;

    #[ORM\Column]
    private ?int $annee = null;

    #[ORM\Column]
    private ?int $kilometrage = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $options = null;

    #[ORM\OneToMany(mappedBy: 'exemplaire', targetEntity: ExemplaireImage::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $image;

    public function __construct()
    {
        $this->image = new ArrayCollection();
    }

    //#[ORM\OneToMany(mappedBy: 'exemplaire', targetEntity: ExemplaireImage::class, orphanRemoval: true, cascade: ['persist'])]
    //private Collection $exemplaireImages;

    //public function __construct()
    //{
     //   $this->exemplaireImages = new ArrayCollection();
        
   // }

    public function __toString()
    {
        return $this->getVehicule();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVehicule(): ?Vehicule
    {
        return $this->vehicule;
    }

    public function setVehicule(?Vehicule $vehicule): static
    {
        $this->vehicule = $vehicule;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    public function setAnnee(int $annee): static
    {
        $this->annee = $annee;

        return $this;
    }

    public function getKilometrage(): ?int
    {
        return $this->kilometrage;
    }

    public function setKilometrage(int $kilometrage): static
    {
        $this->kilometrage = $kilometrage;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getOptions(): ?string
    {
        return $this->options;
    }

    public function setOptions(string $options): static
    {
        $this->options = $options;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, ExemplaireImage>
     */
    public function getImage(): Collection
    {
        return $this->image;
    }

    public function addImage(ExemplaireImage $image): static
    {
        if (!$this->image->contains($image)) {
            $this->image->add($image);
            $image->setExemplaire($this);
        }

        return $this;
    }

    public function removeImage(ExemplaireImage $image): static
    {
        if ($this->image->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getExemplaire() === $this) {
                $image->setExemplaire(null);
            }
        }

        return $this;
    }
}
