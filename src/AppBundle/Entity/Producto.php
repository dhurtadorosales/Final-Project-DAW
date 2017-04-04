<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Producto
 * @ORM\Entity()
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
    private $precioLitro;

    /**
     * @var float
     * @ORM\Column(type="float", precision=2)
     */
    private $stock;

    /**
     * @var Lote[]
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Lote", inversedBy="productos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $lotes;

    /**
     * @var Envase
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Envase", inversedBy="producto")
     * @ORM\JoinColumn(nullable=false)
     */
    private $envase;

    /**
     * @var Linea[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Linea", mappedBy="producto")
     */
    private $lineas;


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
     * Set precioLitro
     *
     * @param float $precioLitro
     *
     * @return Producto
     */
    public function setPrecioLitro($precioLitro)
    {
        $this->precioLitro = $precioLitro;

        return $this;
    }

    /**
     * Get precioLitro
     *
     * @return float
     */
    public function getPrecioLitro()
    {
        return $this->precioLitro;
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
