<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Liquidacion
 * @ORM\Entity()
 */
class Liquidacion
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
     * @var float
     * @ORM\Column(type="float")
     */
    private $beneficio;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private $gasto;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     */
    private $iva;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     */
    private $ivaReducido;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     */
    private $retencion;

    /**
    * @var float
    * @ORM\Column(type="float", nullable=true)
    */
    private $indiceCorrector;

    /**
     * @var Socio
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Socio", inversedBy="liquidaciones")
     */
    private $socio;

    /**
     * @var Porcentaje[]
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Porcentaje", inversedBy="liquidaciones")
     */
    private $porcentajes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->porcentajes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Liquidacion
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
     * Set beneficio
     *
     * @param float $beneficio
     *
     * @return Liquidacion
     */
    public function setBeneficio($beneficio)
    {
        $this->beneficio = $beneficio;

        return $this;
    }

    /**
     * Get beneficio
     *
     * @return float
     */
    public function getBeneficio()
    {
        return $this->beneficio;
    }

    /**
     * Set gasto
     *
     * @param float $gasto
     *
     * @return Liquidacion
     */
    public function setGasto($gasto)
    {
        $this->gasto = $gasto;

        return $this;
    }

    /**
     * Get gasto
     *
     * @return float
     */
    public function getGasto()
    {
        return $this->gasto;
    }

    /**
     * Set iva
     *
     * @param float $iva
     *
     * @return Liquidacion
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
     * Set ivaReducido
     *
     * @param float $ivaReducido
     *
     * @return Liquidacion
     */
    public function setIvaReducido($ivaReducido)
    {
        $this->ivaReducido = $ivaReducido;

        return $this;
    }

    /**
     * Get ivaReducido
     *
     * @return float
     */
    public function getIvaReducido()
    {
        return $this->ivaReducido;
    }

    /**
     * Set retencion
     *
     * @param float $retencion
     *
     * @return Liquidacion
     */
    public function setRetencion($retencion)
    {
        $this->retencion = $retencion;

        return $this;
    }

    /**
     * Get retencion
     *
     * @return float
     */
    public function getRetencion()
    {
        return $this->retencion;
    }

    /**
     * Set indiceCorrector
     *
     * @param float $indiceCorrector
     *
     * @return Liquidacion
     */
    public function setIndiceCorrector($indiceCorrector)
    {
        $this->indiceCorrector = $indiceCorrector;

        return $this;
    }

    /**
     * Get indiceCorrector
     *
     * @return float
     */
    public function getIndiceCorrector()
    {
        return $this->indiceCorrector;
    }

    /**
     * Set socio
     *
     * @param \AppBundle\Entity\Socio $socio
     *
     * @return Liquidacion
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
     * Add porcentaje
     *
     * @param \AppBundle\Entity\Porcentaje $porcentaje
     *
     * @return Liquidacion
     */
    public function addPorcentaje(\AppBundle\Entity\Porcentaje $porcentaje)
    {
        $this->porcentajes[] = $porcentaje;

        return $this;
    }

    /**
     * Remove porcentaje
     *
     * @param \AppBundle\Entity\Porcentaje $porcentaje
     */
    public function removePorcentaje(\AppBundle\Entity\Porcentaje $porcentaje)
    {
        $this->porcentajes->removeElement($porcentaje);
    }

    /**
     * Get porcentajes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPorcentajes()
    {
        return $this->porcentajes;
    }
}
