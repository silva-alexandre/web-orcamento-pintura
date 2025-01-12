<?php

namespace App\Entity;

use App\Repository\ServicoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServicoRepository::class)]
class Servico
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 40)]
    private ?string $tipo = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $valor_unid = null;

    #[ORM\Column(length: 20)]
    private ?string $unid_medida = null;

    /**
     * @var Collection<int, Orcamento>
     */
    #[ORM\OneToMany(targetEntity: Orcamento::class, mappedBy: 'id_servico')]
    private Collection $id_orcamento;

    public function __construct()
    {
        $this->id_orcamento = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): static
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getValorUnid(): ?string
    {
        return $this->valor_unid;
    }

    public function setValorUnid(string $valor_unid): static
    {
        $this->valor_unid = $valor_unid;

        return $this;
    }

    public function getUnidMedida(): ?string
    {
        return $this->unid_medida;
    }

    public function setUnidMedida(string $unid_medida): static
    {
        $this->unid_medida = $unid_medida;

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
            $idOrcamento->setIdServico($this);
        }

        return $this;
    }

    public function removeIdOrcamento(Orcamento $idOrcamento): static
    {
        if ($this->id_orcamento->removeElement($idOrcamento)) {
            // set the owning side to null (unless already changed)
            if ($idOrcamento->getIdServico() === $this) {
                $idOrcamento->setIdServico(null);
            }
        }

        return $this;
    }
}
