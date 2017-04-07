<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Lote
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConsultasRepository")
 */
class Lote
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $temporada;

    /**
     * @var float
     * @ORM\Column(type="float", precision=2)
     */
    private $cantidad;

    /**
     * @var Partida[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Partida", mappedBy="lote")
     * @ORM\JoinColumn(nullable=true)
     */
    private $partidas;

    /**
     * @var Aceite
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Aceite", inversedBy="lotes")
     * @ORM\JoinColumn(nullable=true)
     */
    private $aceite;

    /**
     * @var Producto[]
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Producto", mappedBy="lotes")
     */
    private $productos;

    /**
     * Convierte a string
     */
    public function __toString()
    {
        return $this->getId() . "-" . $this->getTemporada();
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->partidas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->productos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set temporada
     *
     * @param string $temporada
     *
     * @return Lote
     */
    public function setTemporada($temporada)
    {
        $this->temporada = $temporada;

        return $this;
    }

    /**
     * Get temporada
     *
     * @return string
     */
    public function getTemporada()
    {
        return $this->temporada;
    }

    /**
     * Set cantidad
     *
     * @param float $cantidad
     *
     * @return Lote
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return float
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Add partida
     *
     * @param \AppBundle\Entity\Partida $partida
     *
     * @return Lote
     */
    public function addPartida(\AppBundle\Entity\Partida $partida)
    {
        $this->partidas[] = $partida;

        return $this;
    }

    /**
     * Remove partida
     *
     * @param \AppBundle\Entity\Partida $partida
     */
    public function removePartida(\AppBundle\Entity\Partida $partida)
    {
        $this->partidas->removeElement($partida);
    }

    /**
     * Get partidas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPartidas()
    {
        return $this->partidas;
    }

    /**
     * Set aceite
     *
     * @param \AppBundle\Entity\Aceite $aceite
     *
     * @return Lote
     */
    public function setAceite(\AppBundle\Entity\Aceite $aceite = null)
    {
        $this->aceite = $aceite;

        return $this;
    }

    /**
     * Get aceite
     *
     * @return \AppBundle\Entity\Aceite
     */
    public function getAceite()
    {
        return $this->aceite;
    }

    /**
     * Add producto
     *
     * @param \AppBundle\Entity\Producto $producto
     *
     * @return Lote
     */
    public function addProducto(\AppBundle\Entity\Producto $producto)
    {
        $this->productos[] = $producto;

        return $this;
    }

    /**
     * Remove producto
     *
     * @param \AppBundle\Entity\Producto $producto
     */
    public function removeProducto(\AppBundle\Entity\Producto $producto)
    {
        $this->productos->removeElement($producto);
    }

    /**
     * Get productos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductos()
    {
        return $this->productos;
    }
}
