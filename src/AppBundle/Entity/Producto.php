<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Producto
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductoRepository")
 */
class Producto
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @var float
     * @ORM\Column(type="float", precision=2)
     */
    private $stock;

    /**
     * @var float
     * @ORM\Column(type="float", precision=2)
     * @Assert\NotBlank(message="Este campo es obligatorio")
     * @Assert\Regex("/^[0-9]+(\.[0-9]+)?$/")
     */
    private $precio;

    /**
     * @var Lote[]
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Lote", inversedBy="productos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $lotes;

    /**
     * @var Envase
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Envase", inversedBy="productos")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Este campo es obligatorio")
     */
    private $envase;

    /**
     * @var Linea[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Linea", mappedBy="producto")
     * @ORM\JoinColumn(nullable=true)
     */
    private $lineas;

    /**
     * Convierte a string
     */
    public function __toString()
    {
        return $this->getLotes()[0]->getAceite() . " " . $this->getEnvase();
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lotes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->lineas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set stock
     *
     * @param float $stock
     *
     * @return Producto
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return float
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set precio
     *
     * @param float $precio
     *
     * @return Producto
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get precio
     *
     * @return float
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Add lote
     *
     * @param \AppBundle\Entity\Lote $lote
     *
     * @return Producto
     */
    public function addLote(\AppBundle\Entity\Lote $lote)
    {
        $this->lotes[] = $lote;

        return $this;
    }

    /**
     * Remove lote
     *
     * @param \AppBundle\Entity\Lote $lote
     */
    public function removeLote(\AppBundle\Entity\Lote $lote)
    {
        $this->lotes->removeElement($lote);
    }

    /**
     * Get lotes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLotes()
    {
        return $this->lotes;
    }

    /**
     * Set envase
     *
     * @param \AppBundle\Entity\Envase $envase
     *
     * @return Producto
     */
    public function setEnvase(\AppBundle\Entity\Envase $envase)
    {
        $this->envase = $envase;

        return $this;
    }

    /**
     * Get envase
     *
     * @return \AppBundle\Entity\Envase
     */
    public function getEnvase()
    {
        return $this->envase;
    }

    /**
     * Add linea
     *
     * @param \AppBundle\Entity\Linea $linea
     *
     * @return Producto
     */
    public function addLinea(\AppBundle\Entity\Linea $linea)
    {
        $this->lineas[] = $linea;

        return $this;
    }

    /**
     * Remove linea
     *
     * @param \AppBundle\Entity\Linea $linea
     */
    public function removeLinea(\AppBundle\Entity\Linea $linea)
    {
        $this->lineas->removeElement($linea);
    }

    /**
     * Get lineas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLineas()
    {
        return $this->lineas;
    }
}
