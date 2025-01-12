<?php

namespace App\Entity;

use App\Repository\OrcamentoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrcamentoRepository::class)]
class Orcamento
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'id_orcamento')]
    private ?Cliente $id_cliente = null;

    #[ORM\ManyToOne(inversedBy: 'id_orcamento')]
    private ?Servico $id_servico = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private ?string $qtd = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $valor_total = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $data = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCliente(): ?Cliente
    {
        return $this->id_cliente;
    }

    public function setIdCliente(?Cliente $id_cliente): static
    {
        $this->id_cliente = $id_cliente;

        return $this;
    }

    public function getIdServico(): ?Servico
    {
        return $this->id_servico;
    }

    public function setIdServico(?Servico $id_servico): static
    {
        $this->id_servico = $id_servico;

        return $this;
    }

    public function getQtd(): ?string
    {
        return $this->qtd;
    }

    public function setQtd(string $qtd): static
    {
        $this->qtd = $qtd;

        return $this;
    }

    public function getValorTotal(): ?string
    {
        return $this->valor_total;
    }

    public function setValorTotal(?string $valor_total): static
    {
        $this->valor_total = $valor_total;

        return $this;
    }

    public function getData(): ?\DateTimeInterface
    {
        return $this->data;
    }

    public function setData(\DateTimeInterface $data): static
    {
        $this->data = $data;

        return $this;
    }
}
