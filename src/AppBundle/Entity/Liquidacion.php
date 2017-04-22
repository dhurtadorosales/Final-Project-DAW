<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Liquidacion
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LiquidacionRepository")
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
     * @ORM\Column(type="date", nullable=true)
     */
    private $fecha;

    /**
     * @var float
     * @ORM\Column(type="float", precision=2)
     */
    private $iva;

    /**
     * @var float
     * @ORM\Column(type="float", precision=2)
     */
    private $retencion;

    /**
     * @var Socio
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Socio", inversedBy="liquidaciones")
     */
    private $socio;

    /**
     * @var Temporada
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Temporada", inversedBy="liquidaciones")
     */
    private $temporada;


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
     * Set temporada
     *
     * @param \AppBundle\Entity\Temporada $temporada
     *
     * @return Liquidacion
     */
    public function setTemporada(\AppBundle\Entity\Temporada $temporada = null)
    {
        $this->temporada = $temporada;

        return $this;
    }

    /**
     * Get temporada
     *
     * @return \AppBundle\Entity\Temporada
     */
    public function getTemporada()
    {
        return $this->temporada;
    }
}
