<?php

namespace App\Entity;

use App\Repository\StockRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StockRepository::class)
 */
class Stock
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Gym::class)
     */
    private $id_gym;

    /**
     * @ORM\ManyToOne(targetEntity=Produit::class)
     */
    private $id_produit;

    /**
     * @ORM\Column(type="integer")
     */
    private $qte;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdGym(): ?Gym
    {
        return $this->id_gym;
    }

    public function setIdGym(?Gym $id_gym): self
    {
        $this->id_gym = $id_gym;

        return $this;
    }

    public function getIdProduit(): ?Produit
    {
        return $this->id_produit;
    }

    public function setIdProduit(?Produit $id_produit): self
    {
        $this->id_produit = $id_produit;

        return $this;
    }

    public function getQte(): ?int
    {
        return $this->qte;
    }

    public function setQte(int $qte): self
    {
        $this->qte = $qte;

        return $this;
    }
}
