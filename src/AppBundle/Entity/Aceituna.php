<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class Aceituna
 * @ORM\Entity()
 * @UniqueEntity("denominacion")
 */
class Aceituna
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
     * @Assert\NotBlank(message="Este campo es obligatorio")
     * @Assert\Regex("/^[A-Z a-zÑñáéíóúÁÉÍÓÚ]*$/", message="Formato no válido")
     */
    private $denominacion;

    /**
     * @var Finca[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Finca", mappedBy="variedad")
     */
    private $fincas;


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
        $this->fincas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->entregas = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Aceituna
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
     * Add finca
     *
     * @param \AppBundle\Entity\Finca $finca
     *
     * @return Aceituna
     */
    public function addFinca(\AppBundle\Entity\Finca $finca)
    {
        $this->fincas[] = $finca;

        return $this;
    }

    /**
     * Remove finca
     *
     * @param \AppBundle\Entity\Finca $finca
     */
    public function removeFinca(\AppBundle\Entity\Finca $finca)
    {
        $this->fincas->removeElement($finca);
    }

    /**
     * Get fincas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFincas()
    {
        return $this->fincas;
    }

    /**
     * Add entrega
     *
     * @param \AppBundle\Entity\Entrega $entrega
     *
     * @return Aceituna
     */
    public function addEntrega(\AppBundle\Entity\Entrega $entrega)
    {
        $this->entregas[] = $entrega;

        return $this;
    }

    /**
     * Remove entrega
     *
     * @param \AppBundle\Entity\Entrega $entrega
     */
    public function removeEntrega(\AppBundle\Entity\Entrega $entrega)
    {
        $this->entregas->removeElement($entrega);
    }

    /**
     * Get entregas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEntregas()
    {
        return $this->entregas;
    }
}
