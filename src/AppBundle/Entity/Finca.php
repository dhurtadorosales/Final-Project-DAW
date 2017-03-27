<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Finca
 * @ORM\Entity()
 */
class Finca
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
     * @ORM\Column(type="string", length=2)
     */
    private $provincia;

    /**
     * @var string
     * @ORM\Column(type="string", length=3)
     */
    private $municipio;

    /**
     * @var string
     * @ORM\Column(type="string", length=1)
     */
    private $sector;

    /**
     * @var string
     * @ORM\Column(type="string", length=3)
     */
    private $poligono;

    /**
     * @var string
     * @ORM\Column(type="string", length=5)
     */
    private $parcela;

    /**
     * @var string
     * @ORM\Column(type="string", length=4)
     */
    private $idInmueble;

    /**
     * @var string
     * @ORM\Column(type="string", length=2)
     */
    private $caracterControl;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $numPlantas;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $regadio;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $cultivoEcologico;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $partPropietario;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=true)
     */
    private $partArrend;

    /**
     * @var Aceituna
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Aceituna", inversedBy="fincas")
     */
    private $variedad;

    /**
     * @var Pesaje[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Pesaje", mappedBy="finca")
     * @ORM\JoinColumn(nullable=true)
     */
    private $pesajes;

    /**
     * @var Socio
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Socio", inversedBy="fincasPropiedad")
     */
    private $propietario;

    /**
     * @var Socio
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Socio", inversedBy="fincasArrendadas")
     * @ORM\JoinColumn(nullable=true)
     */
    private $arrendatario;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pesajes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set provincia
     *
     * @param string $provincia
     *
     * @return Finca
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get provincia
     *
     * @return string
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * Set municipio
     *
     * @param string $municipio
     *
     * @return Finca
     */
    public function setMunicipio($municipio)
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * Get municipio
     *
     * @return string
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }

    /**
     * Set sector
     *
     * @param string $sector
     *
     * @return Finca
     */
    public function setSector($sector)
    {
        $this->sector = $sector;

        return $this;
    }

    /**
     * Get sector
     *
     * @return string
     */
    public function getSector()
    {
        return $this->sector;
    }

    /**
     * Set poligono
     *
     * @param string $poligono
     *
     * @return Finca
     */
    public function setPoligono($poligono)
    {
        $this->poligono = $poligono;

        return $this;
    }

    /**
     * Get poligono
     *
     * @return string
     */
    public function getPoligono()
    {
        return $this->poligono;
    }

    /**
     * Set parcela
     *
     * @param string $parcela
     *
     * @return Finca
     */
    public function setParcela($parcela)
    {
        $this->parcela = $parcela;

        return $this;
    }

    /**
     * Get parcela
     *
     * @return string
     */
    public function getParcela()
    {
        return $this->parcela;
    }

    /**
     * Set idInmueble
     *
     * @param string $idInmueble
     *
     * @return Finca
     */
    public function setIdInmueble($idInmueble)
    {
        $this->idInmueble = $idInmueble;

        return $this;
    }

    /**
     * Get idInmueble
     *
     * @return string
     */
    public function getIdInmueble()
    {
        return $this->idInmueble;
    }

    /**
     * Set caracterControl
     *
     * @param string $caracterControl
     *
     * @return Finca
     */
    public function setCaracterControl($caracterControl)
    {
        $this->caracterControl = $caracterControl;

        return $this;
    }

    /**
     * Get caracterControl
     *
     * @return string
     */
    public function getCaracterControl()
    {
        return $this->caracterControl;
    }

    /**
     * Set numPlantas
     *
     * @param integer $numPlantas
     *
     * @return Finca
     */
    public function setNumPlantas($numPlantas)
    {
        $this->numPlantas = $numPlantas;

        return $this;
    }

    /**
     * Get numPlantas
     *
     * @return integer
     */
    public function getNumPlantas()
    {
        return $this->numPlantas;
    }

    /**
     * Set regadio
     *
     * @param boolean $regadio
     *
     * @return Finca
     */
    public function setRegadio($regadio)
    {
        $this->regadio = $regadio;

        return $this;
    }

    /**
     * Get regadio
     *
     * @return boolean
     */
    public function getRegadio()
    {
        return $this->regadio;
    }

    /**
     * Set cultivoEcologico
     *
     * @param boolean $cultivoEcologico
     *
     * @return Finca
     */
    public function setCultivoEcologico($cultivoEcologico)
    {
        $this->cultivoEcologico = $cultivoEcologico;

        return $this;
    }

    /**
     * Get cultivoEcologico
     *
     * @return boolean
     */
    public function getCultivoEcologico()
    {
        return $this->cultivoEcologico;
    }

    /**
     * Set partPropietario
     *
     * @param integer $partPropietario
     *
     * @return Finca
     */
    public function setPartPropietario($partPropietario)
    {
        $this->partPropietario = $partPropietario;

        return $this;
    }

    /**
     * Get partPropietario
     *
     * @return integer
     */
    public function getPartPropietario()
    {
        return $this->partPropietario;
    }

    /**
     * Set partArrend
     *
     * @param integer $partArrend
     *
     * @return Finca
     */
    public function setPartArrend($partArrend)
    {
        $this->partArrend = $partArrend;

        return $this;
    }

    /**
     * Get partArrend
     *
     * @return integer
     */
    public function getPartArrend()
    {
        return $this->partArrend;
    }

    /**
     * Set variedad
     *
     * @param \AppBundle\Entity\Aceituna $variedad
     *
     * @return Finca
     */
    public function setVariedad(\AppBundle\Entity\Aceituna $variedad = null)
    {
        $this->variedad = $variedad;

        return $this;
    }

    /**
     * Get variedad
     *
     * @return \AppBundle\Entity\Aceituna
     */
    public function getVariedad()
    {
        return $this->variedad;
    }

    /**
     * Add pesaje
     *
     * @param \AppBundle\Entity\Pesaje $pesaje
     *
     * @return Finca
     */
    public function addPesaje(\AppBundle\Entity\Pesaje $pesaje)
    {
        $this->pesajes[] = $pesaje;

        return $this;
    }

    /**
     * Remove pesaje
     *
     * @param \AppBundle\Entity\Pesaje $pesaje
     */
    public function removePesaje(\AppBundle\Entity\Pesaje $pesaje)
    {
        $this->pesajes->removeElement($pesaje);
    }

    /**
     * Get pesajes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPesajes()
    {
        return $this->pesajes;
    }

    /**
     * Set propietario
     *
     * @param \AppBundle\Entity\Socio $propietario
     *
     * @return Finca
     */
    public function setPropietario(\AppBundle\Entity\Socio $propietario = null)
    {
        $this->propietario = $propietario;

        return $this;
    }

    /**
     * Get propietario
     *
     * @return \AppBundle\Entity\Socio
     */
    public function getPropietario()
    {
        return $this->propietario;
    }

    /**
     * Set arrendatario
     *
     * @param \AppBundle\Entity\Socio $arrendatario
     *
     * @return Finca
     */
    public function setArrendatario(\AppBundle\Entity\Socio $arrendatario = null)
    {
        $this->arrendatario = $arrendatario;

        return $this;
    }

    /**
     * Get arrendatario
     *
     * @return \AppBundle\Entity\Socio
     */
    public function getArrendatario()
    {
        return $this->arrendatario;
    }
}
