<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Aceite
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AceiteRepository")
 * @UniqueEntity("denominacion")
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
     * @Assert\NotBlank(message="Este campo es obligatorio")
     */
    private $denominacion;

    /**
     * @var float
     * @ORM\Column(type="float", precision=3)
     * @Assert\NotBlank(message="Este campo es obligatorio")
     * @Assert\Regex("/^[0-9]+(\.[0-9]+)?$/")
     */
    private $densidadKgLitro;

    /**
     * @var float
     * @ORM\Column(type="float", precision=2)
     * @Assert\NotBlank(message="Este campo es obligatorio")
     * @Assert\Regex("/^[0-9]+(\.[0-9]+)?$/")
     */
    private $precioKg;

    /**
     * @var Lote[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Lote", mappedBy="aceite")
     * @ORM\JoinColumn(nullable=true)
     */
    private $lotes;

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
     * Set densidadKgLitro
     *
     * @param float $densidadKgLitro
     *
     * @return Aceite
     */
    public function setDensidadKgLitro($densidadKgLitro)
    {
        $this->densidadKgLitro = $densidadKgLitro;

        return $this;
    }

    /**
     * Get densidadKgLitro
     *
     * @return float
     */
    public function getDensidadKgLitro()
    {
        return $this->densidadKgLitro;
    }

    /**
     * Set precioKg
     *
     * @param float $precioKg
     *
     * @return Aceite
     */
    public function setPrecioKg($precioKg)
    {
        $this->precioKg = $precioKg;

        return $this;
    }

    /**
     * Get precioKg
     *
     * @return float
     */
    public function getPrecioKg()
    {
        return $this->precioKg;
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
}
