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
     * @ORM\JoinColumn(nullable=true)
     */
    private $factura;

    /**
     * @var Retirada
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Retirada", inversedBy="lineas")
     * @ORM\JoinColumn(nullable=true)
     */
    private $retirada;

    /**
     * @var Deposito
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Deposito", inversedBy="lineas")
     */
    private $aceite;

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
     * Set factura
     *
     * @param \AppBundle\Entity\Venta $factura
     *
     * @return Linea
     */
    public function setFactura(\AppBundle\Entity\Venta $factura = null)
    {
        $this->factura = $factura;

        return $this;
    }

    /**
     * Get factura
     *
     * @return \AppBundle\Entity\Venta
     */
    public function getFactura()
    {
        return $this->factura;
    }

    /**
     * Set retirada
     *
     * @param \AppBundle\Entity\Retirada $retirada
     *
     * @return Linea
     */
    public function setRetirada(\AppBundle\Entity\Retirada $retirada = null)
    {
        $this->retirada = $retirada;

        return $this;
    }

    /**
     * Get retirada
     *
     * @return \AppBundle\Entity\Retirada
     */
    public function getRetirada()
    {
        return $this->retirada;
    }

    /**
     * Set aceite
     *
     * @param \AppBundle\Entity\Deposito $aceite
     *
     * @return Linea
     */
    public function setAceite(\AppBundle\Entity\Deposito $aceite = null)
    {
        $this->aceite = $aceite;

        return $this;
    }

    /**
     * Get aceite
     *
     * @return \AppBundle\Entity\Deposito
     */
    public function getAceite()
    {
        return $this->aceite;
    }
}
