<?php

namespace App\Entity;

use App\Repository\DevisEntityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DevisEntityRepository::class)]
class DevisEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $client_name = null;

    #[ORM\Column(length: 255)]
    private ?string $client_email = null;

    #[ORM\Column(length: 255)]
    private ?string $demand_type = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $message = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientName(): ?string
    {
        return $this->client_name;
    }

    public function setClientName(string $client_name): self
    {
        $this->client_name = $client_name;

        return $this;
    }

    public function getClientEmail(): ?string
    {
        return $this->client_email;
    }

    public function setClientEmail(string $client_email): self
    {
        $this->client_email = $client_email;

        return $this;
    }

    public function getDemandType(): ?string
    {
        return $this->demand_type;
    }

    public function setDemandType(string $demand_type): self
    {
        $this->demand_type = $demand_type;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }
}
