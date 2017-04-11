<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Porcentaje
 * @ORM\Entity()
 */
class Porcentaje
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
    private $denominacion;

    /**
     * @var float
     * @ORM\Column(type="float", precision=2)
     */
    private $cantidad;

    /**
     * @var Venta[]
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Venta", mappedBy="porcentajes")
     * @ORM\JoinColumn(nullable=true)
     */
    private $ventas;

    /**
     * @var Liquidacion[]
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Liquidacion", mappedBy="porcentajes")
     * @ORM\JoinColumn(nullable=true)
     */
    private $liquidaciones;

    /**
     * Convierte a string
     */
    public function __toString()
    {
        return $this->getDenominacion();
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ventas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->liquidaciones = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set denominacion
     *
     * @param string $denominacion
     *
     * @return Porcentaje
     */
    public function setDenominacion($denominacion)
    {
        $this->denominacion = $denominacion;

        return $this;
    }

    /**
     * Get denominacion
     *
     * @return string
     */
    public function getDenominacion()
    {
        return $this->denominacion;
    }

    /**
     * Set cantidad
     *
     * @param float $cantidad
     *
     * @return Porcentaje
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
     * Add venta
     *
     * @param \AppBundle\Entity\Venta $venta
     *
     * @return Porcentaje
     */
    public function addVenta(\AppBundle\Entity\Venta $venta)
    {
        $this->ventas[] = $venta;

        return $this;
    }

    /**
     * Remove venta
     *
     * @param \AppBundle\Entity\Venta $venta
     */
    public function removeVenta(\AppBundle\Entity\Venta $venta)
    {
        $this->ventas->removeElement($venta);
    }

    /**
     * Get ventas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVentas()
    {
        return $this->ventas;
    }

    /**
     * Add liquidacione
     *
     * @param \AppBundle\Entity\Liquidacion $liquidacione
     *
     * @return Porcentaje
     */
    public function addLiquidacione(\AppBundle\Entity\Liquidacion $liquidacione)
    {
        $this->liquidaciones[] = $liquidacione;

        return $this;
    }

    /**
     * Remove liquidacione
     *
     * @param \AppBundle\Entity\Liquidacion $liquidacione
     */
    public function removeLiquidacione(\AppBundle\Entity\Liquidacion $liquidacione)
    {
        $this->liquidaciones->removeElement($liquidacione);
    }

    /**
     * Get liquidaciones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLiquidaciones()
    {
        return $this->liquidaciones;
    }
}
