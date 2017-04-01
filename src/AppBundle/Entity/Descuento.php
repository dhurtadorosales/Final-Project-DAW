<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Descuento
 * @ORM\Entity()
 */
class Descuento
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
    private $porcentaje;

    /**
     * @var Socio[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Socio", mappedBy="descuento")
     * @ORM\JoinColumn(nullable=true)
     */
    private $socios;

    /**
     * @var Empleado[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Empleado", mappedBy="descuento")
     * @ORM\JoinColumn(nullable=true)
     */
    private $empleados;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->socios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->empleados = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set porcentaje
     *
     * @param float $porcentaje
     *
     * @return Descuento
     */
    public function setPorcentaje($porcentaje)
    {
        $this->porcentaje = $porcentaje;

        return $this;
    }

    /**
     * Get porcentaje
     *
     * @return float
     */
    public function getPorcentaje()
    {
        return $this->porcentaje;
    }

    /**
     * Add socio
     *
     * @param \AppBundle\Entity\Socio $socio
     *
     * @return Descuento
     */
    public function addSocio(\AppBundle\Entity\Socio $socio)
    {
        $this->socios[] = $socio;

        return $this;
    }

    /**
     * Remove socio
     *
     * @param \AppBundle\Entity\Socio $socio
     */
    public function removeSocio(\AppBundle\Entity\Socio $socio)
    {
        $this->socios->removeElement($socio);
    }

    /**
     * Get socios
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSocios()
    {
        return $this->socios;
    }

    /**
     * Add empleado
     *
     * @param \AppBundle\Entity\Empleado $empleado
     *
     * @return Descuento
     */
    public function addEmpleado(\AppBundle\Entity\Empleado $empleado)
    {
        $this->empleados[] = $empleado;

        return $this;
    }

    /**
     * Remove empleado
     *
     * @param \AppBundle\Entity\Empleado $empleado
     */
    public function removeEmpleado(\AppBundle\Entity\Empleado $empleado)
    {
        $this->empleados->removeElement($empleado);
    }

    /**
     * Get empleados
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmpleados()
    {
        return $this->empleados;
    }
}
