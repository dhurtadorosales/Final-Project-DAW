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
    private $precio;

    /**
     * @var float
     * @ORM\Column(type="float", precision=2)
     */
    private $descuentoSocios;

    /**
     * @var float
     * @ORM\Column(type="float", precision=2)
     */
    private $descuentoEmpleados;

    /**
     * @var Amasada[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Amasada", mappedBy="aceite")
     * @ORM\JoinColumn(nullable=true)
     */
    private $amasadas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->amasadas = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set precio
     *
     * @param float $precio
     *
     * @return Aceite
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
     * Set descuentoSocios
     *
     * @param float $descuentoSocios
     *
     * @return Aceite
     */
    public function setDescuentoSocios($descuentoSocios)
    {
        $this->descuentoSocios = $descuentoSocios;

        return $this;
    }

    /**
     * Get descuentoSocios
     *
     * @return float
     */
    public function getDescuentoSocios()
    {
        return $this->descuentoSocios;
    }

    /**
     * Set descuentoEmpleados
     *
     * @param float $descuentoEmpleados
     *
     * @return Aceite
     */
    public function setDescuentoEmpleados($descuentoEmpleados)
    {
        $this->descuentoEmpleados = $descuentoEmpleados;

        return $this;
    }

    /**
     * Get descuentoEmpleados
     *
     * @return float
     */
    public function getDescuentoEmpleados()
    {
        return $this->descuentoEmpleados;
    }

    /**
     * Add amasada
     *
     * @param \AppBundle\Entity\Amasada $amasada
     *
     * @return Aceite
     */
    public function addAmasada(\AppBundle\Entity\Amasada $amasada)
    {
        $this->amasadas[] = $amasada;

        return $this;
    }

    /**
     * Remove amasada
     *
     * @param \AppBundle\Entity\Amasada $amasada
     */
    public function removeAmasada(\AppBundle\Entity\Amasada $amasada)
    {
        $this->amasadas->removeElement($amasada);
    }

    /**
     * Get amasadas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAmasadas()
    {
        return $this->amasadas;
    }
}
