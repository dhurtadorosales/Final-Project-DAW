<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Venta
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConsultasRepository")
 */
class Venta
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $numero;

    /**
     * @var \DateTime
     * @ORM\Column(type="date")
     */
    private $fecha;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private $suma;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     */
    private $iva;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     */
    private $descuento;

    /**
     * @var Cliente
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Cliente", inversedBy="ventas")
     * @ORM\JoinColumn(nullable=true)
     */
    private $cliente;

    /**
     * @var Socio
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Socio", inversedBy="ventas")
     * @ORM\JoinColumn(nullable=true)
     */
    private $socio;

    /**
     * @var Linea[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Linea", mappedBy="venta")
     */
    private $lineas;

    /**
     * @var Temporada
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Temporada", inversedBy="ventas")
     * @ORM\JoinColumn(nullable=true)
     */
    private $temporada;

    /**
     * Constructor
     */
    public function __construct()
    {
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
     * Set numero
     *
     * @param integer $numero
     *
     * @return Venta
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return integer
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Venta
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set suma
     *
     * @param float $suma
     *
     * @return Venta
     */
    public function setSuma($suma)
    {
        $this->suma = $suma;

        return $this;
    }

    /**
     * Get suma
     *
     * @return float
     */
    public function getSuma()
    {
        return $this->suma;
    }

    /**
     * Set iva
     *
     * @param float $iva
     *
     * @return Venta
     */
    public function setIva($iva)
    {
        $this->iva = $iva;

        return $this;
    }

    /**
     * Get iva
     *
     * @return float
     */
    public function getIva()
    {
        return $this->iva;
    }

    /**
     * Set descuento
     *
     * @param float $descuento
     *
     * @return Venta
     */
    public function setDescuento($descuento)
    {
        $this->descuento = $descuento;

        return $this;
    }

    /**
     * Get descuento
     *
     * @return float
     */
    public function getDescuento()
    {
        return $this->descuento;
    }

    /**
     * Set cliente
     *
     * @param \AppBundle\Entity\Cliente $cliente
     *
     * @return Venta
     */
    public function setCliente(\AppBundle\Entity\Cliente $cliente = null)
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente
     *
     * @return \AppBundle\Entity\Cliente
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set socio
     *
     * @param \AppBundle\Entity\Socio $socio
     *
     * @return Venta
     */
    public function setSocio(\AppBundle\Entity\Socio $socio = null)
    {
        $this->socio = $socio;

        return $this;
    }

    /**
     * Get socio
     *
     * @return \AppBundle\Entity\Socio
     */
    public function getSocio()
    {
        return $this->socio;
    }

    /**
     * Add linea
     *
     * @param \AppBundle\Entity\Linea $linea
     *
     * @return Venta
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

    /**
     * Set temporada
     *
     * @param \AppBundle\Entity\Temporada $temporada
     *
     * @return Venta
     */
    public function setTemporada(\AppBundle\Entity\Temporada $temporada = null)
    {
        $this->temporada = $temporada;

        return $this;
    }

    /**
     * Get temporada
     *
     * @return \AppBundle\Entity\Temporada
     */
    public function getTemporada()
    {
        return $this->temporada;
    }
}
