<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Linea
 * @ORM\Entity()
 */
class Linea
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
    private $cantidad;

    /**
     * @var Venta
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Venta", inversedBy="lineas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $venta;

    /**
     * @var Producto
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Producto", inversedBy="producto")
     */
    private $producto;

    /**
     * @var Porcentaje
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Porcentaje", inversedBy="lineas")
     */
    private $porcentaje;



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
     * Set cantidad
     *
     * @param integer $cantidad
     *
     * @return Linea
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set venta
     *
     * @param \AppBundle\Entity\Venta $venta
     *
     * @return Linea
     */
    public function setVenta(\AppBundle\Entity\Venta $venta)
    {
        $this->venta = $venta;

        return $this;
    }

    /**
     * Get venta
     *
     * @return \AppBundle\Entity\Venta
     */
    public function getVenta()
    {
        return $this->venta;
    }

    /**
     * Set producto
     *
     * @param \AppBundle\Entity\Producto $producto
     *
     * @return Linea
     */
    public function setProducto(\AppBundle\Entity\Producto $producto = null)
    {
        $this->producto = $producto;

        return $this;
    }

    /**
     * Get producto
     *
     * @return \AppBundle\Entity\Producto
     */
    public function getProducto()
    {
        return $this->producto;
    }

    /**
     * Set porcentaje
     *
     * @param \AppBundle\Entity\Porcentaje $porcentaje
     *
     * @return Linea
     */
    public function setPorcentaje(\AppBundle\Entity\Porcentaje $porcentaje = null)
    {
        $this->porcentaje = $porcentaje;

        return $this;
    }

    /**
     * Get porcentaje
     *
     * @return \AppBundle\Entity\Porcentaje
     */
    public function getPorcentaje()
    {
        return $this->porcentaje;
    }
}
