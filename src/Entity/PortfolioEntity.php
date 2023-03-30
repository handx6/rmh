<?php

namespace App\Entity;

use App\Repository\PortfolioEntityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PortfolioEntityRepository::class)]
class PortfolioEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $img = [];

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $category = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImg(): array
    {
        return $this->img;
    }

    public function setImg(?array $img): self
    {
        $this->img = $img;

        return $this;
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCategory(): array
    {
        return $this->category;
    }

    public function setCategory(?array $category): self
    {
        $this->category = $category;

        return $this;
    }
}
