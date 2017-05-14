<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Socio
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SocioRepository")
 */
class Socio
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
     * @Assert\NotBlank(message="Este campo es obligatorio")
     */
    private $fechaAlta;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $activo;

    /**
     * @var \DateTime
     * @ORM\Column(type="date", nullable=true)
     */
    private $fechaBaja;

    /**
     * @var Usuario
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Usuario", mappedBy="socio")
     */
    private $usuario;

    /**
     * @var Finca[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Finca", mappedBy="propietario")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fincasPropiedad;

    /**
     * @var Finca[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Finca", mappedBy="arrendatario")
     * @ORM\JoinColumn(nullable=true)
     */
    private $fincasArrendadas;

    /**
     * @var Liquidacion[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Liquidacion", mappedBy="socio")
     * @ORM\JoinColumn(nullable=true)
     */
    private $liquidaciones;

    /**
     * Convierte a string
     */
    public function __toString()
    {
        return $this->getUsuario()->__toString();
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fincasPropiedad = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fincasArrendadas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->liquidaciones = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set fechaAlta
     *
     * @param \DateTime $fechaAlta
     *
     * @return Socio
     */
    public function setFechaAlta($fechaAlta)
    {
        $this->fechaAlta = $fechaAlta;

        return $this;
    }

    /**
     * Get fechaAlta
     *
     * @return \DateTime
     */
    public function getFechaAlta()
    {
        return $this->fechaAlta;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Socio
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set fechaBaja
     *
     * @param \DateTime $fechaBaja
     *
     * @return Socio
     */
    public function setFechaBaja($fechaBaja)
    {
        $this->fechaBaja = $fechaBaja;

        return $this;
    }

    /**
     * Get fechaBaja
     *
     * @return \DateTime
     */
    public function getFechaBaja()
    {
        return $this->fechaBaja;
    }

    /**
     * Set usuario
     *
     * @param \AppBundle\Entity\Usuario $usuario
     *
     * @return Socio
     */
    public function setUsuario(\AppBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \AppBundle\Entity\Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Add fincasPropiedad
     *
     * @param \AppBundle\Entity\Finca $fincasPropiedad
     *
     * @return Socio
     */
    public function addFincasPropiedad(\AppBundle\Entity\Finca $fincasPropiedad)
    {
        $this->fincasPropiedad[] = $fincasPropiedad;

        return $this;
    }

    /**
     * Remove fincasPropiedad
     *
     * @param \AppBundle\Entity\Finca $fincasPropiedad
     */
    public function removeFincasPropiedad(\AppBundle\Entity\Finca $fincasPropiedad)
    {
        $this->fincasPropiedad->removeElement($fincasPropiedad);
    }

    /**
     * Get fincasPropiedad
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFincasPropiedad()
    {
        return $this->fincasPropiedad;
    }

    /**
     * Add fincasArrendada
     *
     * @param \AppBundle\Entity\Finca $fincasArrendada
     *
     * @return Socio
     */
    public function addFincasArrendada(\AppBundle\Entity\Finca $fincasArrendada)
    {
        $this->fincasArrendadas[] = $fincasArrendada;

        return $this;
    }

    /**
     * Remove fincasArrendada
     *
     * @param \AppBundle\Entity\Finca $fincasArrendada
     */
    public function removeFincasArrendada(\AppBundle\Entity\Finca $fincasArrendada)
    {
        $this->fincasArrendadas->removeElement($fincasArrendada);
    }

    /**
     * Get fincasArrendadas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFincasArrendadas()
    {
        return $this->fincasArrendadas;
    }

    /**
     * Add liquidacione
     *
     * @param \AppBundle\Entity\Liquidacion $liquidacione
     *
     * @return Socio
     */
    public function addLiquidacione(\AppBundle\Entity\Liquidacion $liquidacione)
    {
        $this->liquidaciones[] = $liquidacione;

        return $this;
    }

    /**
     * Remove liquidacione
     *
     * @param \AppBundle\Entity\Liquidacion $liquidacione
     */
    public function removeLiquidacione(\AppBundle\Entity\Liquidacion $liquidacione)
    {
        $this->liquidaciones->removeElement($liquidacione);
    }

    /**
     * Get liquidaciones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLiquidaciones()
    {
        return $this->liquidaciones;
    }
}
