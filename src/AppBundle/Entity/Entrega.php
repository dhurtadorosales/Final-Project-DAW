<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Entrega
 * @ORM\Entity()
 */
class Entrega
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
     * @var \DateTime
     * @ORM\Column(type="time")
     */
    private $horaInicio;

    /**
     * @var \DateTime
     * @ORM\Column(type="time")
     */
    private $horaFin;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $peso;

    /**
     * @var float
     * @ORM\Column(type="float", precision=2)
     */
    private $rendimiento;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $sancion;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $observaciones;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $bascula;

    /**
     * @var Tipo
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Tipo", inversedBy="pesajes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tipo;

    /**
     * @var Amasada
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Amasada", inversedBy="entregas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $amasada;

    /**
     * @var Finca
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Finca", inversedBy="entregas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $finca;



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
     * @return Entrega
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
     * Set horaInicio
     *
     * @param \DateTime $horaInicio
     *
     * @return Entrega
     */
    public function setHoraInicio($horaInicio)
    {
        $this->horaInicio = $horaInicio;

        return $this;
    }

    /**
     * Get horaInicio
     *
     * @return \DateTime
     */
    public function getHoraInicio()
    {
        return $this->horaInicio;
    }

    /**
     * Set horaFin
     *
     * @param \DateTime $horaFin
     *
     * @return Entrega
     */
    public function setHoraFin($horaFin)
    {
        $this->horaFin = $horaFin;

        return $this;
    }

    /**
     * Get horaFin
     *
     * @return \DateTime
     */
    public function getHoraFin()
    {
        return $this->horaFin;
    }

    /**
     * Set peso
     *
     * @param integer $peso
     *
     * @return Entrega
     */
    public function setPeso($peso)
    {
        $this->peso = $peso;

        return $this;
    }

    /**
     * Get peso
     *
     * @return integer
     */
    public function getPeso()
    {
        return $this->peso;
    }

    /**
     * Set rendimiento
     *
     * @param float $rendimiento
     *
     * @return Entrega
     */
    public function setRendimiento($rendimiento)
    {
        $this->rendimiento = $rendimiento;

        return $this;
    }

    /**
     * Get rendimiento
     *
     * @return float
     */
    public function getRendimiento()
    {
        return $this->rendimiento;
    }

    /**
     * Set sancion
     *
     * @param integer $sancion
     *
     * @return Entrega
     */
    public function setSancion($sancion)
    {
        $this->sancion = $sancion;

        return $this;
    }

    /**
     * Get sancion
     *
     * @return integer
     */
    public function getSancion()
    {
        return $this->sancion;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return Entrega
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set bascula
     *
     * @param string $bascula
     *
     * @return Entrega
     */
    public function setBascula($bascula)
    {
        $this->bascula = $bascula;

        return $this;
    }

    /**
     * Get bascula
     *
     * @return string
     */
    public function getBascula()
    {
        return $this->bascula;
    }

    /**
     * Set tipo
     *
     * @param \AppBundle\Entity\Tipo $tipo
     *
     * @return Entrega
     */
    public function setTipo(\AppBundle\Entity\Tipo $tipo = null)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return \AppBundle\Entity\Tipo
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set amasada
     *
     * @param \AppBundle\Entity\Amasada $amasada
     *
     * @return Entrega
     */
    public function setAmasada(\AppBundle\Entity\Amasada $amasada = null)
    {
        $this->amasada = $amasada;

        return $this;
    }

    /**
     * Get amasada
     *
     * @return \AppBundle\Entity\Amasada
     */
    public function getAmasada()
    {
        return $this->amasada;
    }

    /**
     * Set finca
     *
     * @param \AppBundle\Entity\Finca $finca
     *
     * @return Entrega
     */
    public function setFinca(\AppBundle\Entity\Finca $finca = null)
    {
        $this->finca = $finca;

        return $this;
    }

    /**
     * Get finca
     *
     * @return \AppBundle\Entity\Finca
     */
    public function getFinca()
    {
        return $this->finca;
    }
}
