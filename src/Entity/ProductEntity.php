<?php

namespace App\Entity;

use App\Repository\ProductEntityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductEntityRepository::class)]
class ProductEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $url_img = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $category = [];

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $size = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrlImg(): ?string
    {
        return $this->url_img;
    }

    public function setUrlImg(string $url_img): self
    {
        $this->url_img = $url_img;

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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getSize(): array
    {
        return $this->size;
    }

    public function setSize(?array $size): self
    {
        $this->size = $size;

        return $this;
    }
}
