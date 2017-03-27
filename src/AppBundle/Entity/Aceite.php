<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Aceite
 * @ORM\Entity()
 */
class Aceite
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
     * @ORM\Column(type="string", unique=true)
     */
    private $denominacion;

    /**
     * @var float
     * @ORM\Column(type="float", precision=2)
     */
    private $precioSocios;

    /**
     * @var float
     * @ORM\Column(type="float", precision=2)
     */
    private $precioClientes;

    /**
     * @var float
     * @ORM\Column(type="float", precision=2)
     */
    private $precioEmpleados;

    /**
     * @var Lote[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Lote", mappedBy="aceite")
     * @ORM\JoinColumn(nullable=true)
     */
    private $lotes;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lotes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Aceite
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
     * Set precioSocios
     *
     * @param float $precioSocios
     *
     * @return Aceite
     */
    public function setPrecioSocios($precioSocios)
    {
        $this->precioSocios = $precioSocios;

        return $this;
    }

    /**
     * Get precioSocios
     *
     * @return float
     */
    public function getPrecioSocios()
    {
        return $this->precioSocios;
    }

    /**
     * Set precioClientes
     *
     * @param float $precioClientes
     *
     * @return Aceite
     */
    public function setPrecioClientes($precioClientes)
    {
        $this->precioClientes = $precioClientes;

        return $this;
    }

    /**
     * Get precioClientes
     *
     * @return float
     */
    public function getPrecioClientes()
    {
        return $this->precioClientes;
    }

    /**
     * Add lote
     *
     * @param \AppBundle\Entity\Lote $lote
     *
     * @return Aceite
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
     * Set precioEmpleados
     *
     * @param float $precioEmpleados
     *
     * @return Aceite
     */
    public function setPrecioEmpleados($precioEmpleados)
    {
        $this->precioEmpleados = $precioEmpleados;

        return $this;
    }

    /**
     * Get precioEmpleados
     *
     * @return float
     */
    public function getPrecioEmpleados()
    {
        return $this->precioEmpleados;
    }
}
