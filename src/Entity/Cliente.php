<?php

namespace App\Entity;

use App\Repository\ClienteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClienteRepository::class)]
class Cliente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 90)]
    private ?string $nome = null;

    #[ORM\Column(length: 80)]
    private ?string $contato = null;

    /**
     * @var Collection<int, Orcamento>
     */
    #[ORM\OneToMany(targetEntity: Orcamento::class, mappedBy: 'id_cliente')]
    private Collection $id_orcamento;

    public function __construct()
    {
        $this->id_orcamento = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): static
    {
        $this->nome = $nome;

        return $this;
    }

    public function getContato(): ?string
    {
        return $this->contato;
    }

    public function setContato(string $contato): static
    {
        $this->contato = $contato;

        return $this;
    }

    /**
     * @return Collection<int, Orcamento>
     */
    public function getIdOrcamento(): Collection
    {
        return $this->id_orcamento;
    }

    public function addIdOrcamento(Orcamento $idOrcamento): static
    {
        if (!$this->id_orcamento->contains($idOrcamento)) {
            $this->id_orcamento->add($idOrcamento);
            $idOrcamento->setIdCliente($this);
        }

        return $this;
    }

    public function removeIdOrcamento(Orcamento $idOrcamento): static
    {
        if ($this->id_orcamento->removeElement($idOrcamento)) {
            // set the owning side to null (unless already changed)
            if ($idOrcamento->getIdCliente() === $this) {
                $idOrcamento->setIdCliente(null);
            }
        }

        return $this;
    }
}
