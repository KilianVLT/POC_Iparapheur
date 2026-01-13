<?php

namespace App\Entity;

use App\Repository\DocumentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DocumentRepository::class)]
class Document
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $ged_id = null;

    #[ORM\Column(length: 75)]
    private ?string $document_name = null;

    #[ORM\Column(length: 50)]
    private ?string $responsable_name = null;

    #[ORM\Column(length: 50)]
    private ?string $responsable_surname = null;

    #[ORM\Column(length: 50)]
    private ?string $type = null;

    #[ORM\Column(length: 50)]
    private ?string $subtype = null;

    #[ORM\Column(length: 50)]
    private ?string $status = null;

    #[ORM\Column]
    private ?\DateTime $last_update = null;

    #[ORM\Column(length: 20)]
    private ?string $origin = null;

    /**
     * @var Collection<int, ThirdParty>
     */
    #[ORM\ManyToMany(targetEntity: ThirdParty::class, inversedBy: 'documents')]
    private Collection $thirdparties;

    public function __construct()
    {
        $this->thirdparties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGedId(): ?string
    {
        return $this->ged_id;
    }

    public function setGedId(string $ged_id): static
    {
        $this->ged_id = $ged_id;

        return $this;
    }

    public function getDocumentName(): ?string
    {
        return $this->document_name;
    }

    public function setDocumentName(string $document_name): static
    {
        $this->document_name = $document_name;

        return $this;
    }

    public function getResponsableName(): ?string
    {
        return $this->responsable_name;
    }

    public function setResponsableName(string $responsable_name): static
    {
        $this->responsable_name = $responsable_name;

        return $this;
    }

    public function getResponsableSurname(): ?string
    {
        return $this->responsable_surname;
    }

    public function setResponsableSurname(string $responsable_surname): static
    {
        $this->responsable_surname = $responsable_surname;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getSubtype(): ?string
    {
        return $this->subtype;
    }

    public function setSubtype(string $subtype): static
    {
        $this->subtype = $subtype;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getLastUpdate(): ?\DateTime
    {
        return $this->last_update;
    }

    public function setLastUpdate(\DateTime $last_update): static
    {
        $this->last_update = $last_update;

        return $this;
    }

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function setOrigin(string $origin): static
    {
        $this->origin = $origin;

        return $this;
    }

    /**
     * @return Collection<int, ThirdParty>
     */
    public function getThirdparties(): Collection
    {
        return $this->thirdparties;
    }

    public function addThirdparty(ThirdParty $thirdparty): static
    {
        if (!$this->thirdparties->contains($thirdparty)) {
            $this->thirdparties->add($thirdparty);
        }

        return $this;
    }

    public function removeThirdparty(ThirdParty $thirdparty): static
    {
        $this->thirdparties->removeElement($thirdparty);

        return $this;
    }
}
