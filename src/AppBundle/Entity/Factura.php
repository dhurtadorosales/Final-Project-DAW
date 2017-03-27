<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Factura
 * @ORM\Entity()
 */
class Factura
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @var \DateTime
     * @ORM\Column(type="date")
     */
    private $fecha;

    /**
     * @var Cliente
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Cliente", inversedBy="facturas")
     */
    private $cliente;

    /**
     * @var Linea[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Linea", mappedBy="factura")
     */
    private $lineas;
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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Factura
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
     * Set cliente
     *
     * @param \AppBundle\Entity\Cliente $cliente
     *
     * @return Factura
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
     * Add linea
     *
     * @param \AppBundle\Entity\Linea $linea
     *
     * @return Factura
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
