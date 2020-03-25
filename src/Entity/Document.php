<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DocumentRepository")
 */
class Document
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
    private $name;

    /**
     * @ORM\Column(type="text", length=255)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Document", inversedBy="file")
     * @ORM\JoinColumn(nullable=false)
     */
    private $document;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Document", mappedBy="document", orphanRemoval=true)
     */
    private $file;

    public function __construct()
    {
        $this->file = new ArrayCollection();
    }

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

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDocument(): ?self
    {
        return $this->document;
    }

    public function setDocument(?self $document): self
    {
        $this->document = $document;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getFile(): Collection
    {
        return $this->file;
    }

    public function addFile(self $file): self
    {
        if (!$this->file->contains($file)) {
            $this->file[] = $file;
            $file->setDocument($this);
        }

        return $this;
    }

    public function removeFile(self $file): self
    {
        if ($this->file->contains($file)) {
            $this->file->removeElement($file);
            // set the owning side to null (unless already changed)
            if ($file->getDocument() === $this) {
                $file->setDocument(null);
            }
        }

        return $this;
    }
}
