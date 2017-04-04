<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var string
     * @ORM\Column(type="string", length=9, unique=true)
     */
    private $nif;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $nombre;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $apellidos;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $calle;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $numero;

    /**
     * @var string
     * @ORM\Column(type="string", length=1, nullable=true)
     */
    private $bloque;

    /**
     * @var string
     * @ORM\Column(type="string", length=1, nullable=true)
     */
    private $escalera;

    /**
     * @var string
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    private $piso;

    /**
     * @var string
     * @ORM\Column(type="string", length=1, nullable=true)
     */
    private $letra;

    /**
     * @var string
     * @ORM\Column(type="string", length=5)
     */
    private $codigoPostal;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $localidad;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $provincia;

    /**
     * @var string
     * @ORM\Column(type="string", length=9)
     */
    private $telefono;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $email;

    /**
     * @var \DateTime
     * @ORM\Column(type="date")
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
     * @var Venta[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Venta", mappedBy="socio")
     * @ORM\JoinColumn(nullable=true)
     */
    private $ventas;

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
        return $this->getNombre() . " " . $this->getApellidos();
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fincasPropiedad = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fincasArrendadas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ventas = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nif
     *
     * @param string $nif
     *
     * @return Socio
     */
    public function setNif($nif)
    {
        $this->nif = $nif;

        return $this;
    }

    /**
     * Get nif
     *
     * @return string
     */
    public function getNif()
    {
        return $this->nif;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Socio
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apellidos
     *
     * @param string $apellidos
     *
     * @return Socio
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set calle
     *
     * @param string $calle
     *
     * @return Socio
     */
    public function setCalle($calle)
    {
        $this->calle = $calle;

        return $this;
    }

    /**
     * Get calle
     *
     * @return string
     */
    public function getCalle()
    {
        return $this->calle;
    }

    /**
     * Set numero
     *
     * @param string $numero
     *
     * @return Socio
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set bloque
     *
     * @param string $bloque
     *
     * @return Socio
     */
    public function setBloque($bloque)
    {
        $this->bloque = $bloque;

        return $this;
    }

    /**
     * Get bloque
     *
     * @return string
     */
    public function getBloque()
    {
        return $this->bloque;
    }

    /**
     * Set escalera
     *
     * @param string $escalera
     *
     * @return Socio
     */
    public function setEscalera($escalera)
    {
        $this->escalera = $escalera;

        return $this;
    }

    /**
     * Get escalera
     *
     * @return string
     */
    public function getEscalera()
    {
        return $this->escalera;
    }

    /**
     * Set piso
     *
     * @param string $piso
     *
     * @return Socio
     */
    public function setPiso($piso)
    {
        $this->piso = $piso;

        return $this;
    }

    /**
     * Get piso
     *
     * @return string
     */
    public function getPiso()
    {
        return $this->piso;
    }

    /**
     * Set letra
     *
     * @param string $letra
     *
     * @return Socio
     */
    public function setLetra($letra)
    {
        $this->letra = $letra;

        return $this;
    }

    /**
     * Get letra
     *
     * @return string
     */
    public function getLetra()
    {
        return $this->letra;
    }

    /**
     * Set codigoPostal
     *
     * @param string $codigoPostal
     *
     * @return Socio
     */
    public function setCodigoPostal($codigoPostal)
    {
        $this->codigoPostal = $codigoPostal;

        return $this;
    }

    /**
     * Get codigoPostal
     *
     * @return string
     */
    public function getCodigoPostal()
    {
        return $this->codigoPostal;
    }

    /**
     * Set localidad
     *
     * @param string $localidad
     *
     * @return Socio
     */
    public function setLocalidad($localidad)
    {
        $this->localidad = $localidad;

        return $this;
    }

    /**
     * Get localidad
     *
     * @return string
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }

    /**
     * Set provincia
     *
     * @param string $provincia
     *
     * @return Socio
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
     * Set telefono
     *
     * @param string $telefono
     *
     * @return Socio
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Socio
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
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
     * Add venta
     *
     * @param \AppBundle\Entity\Venta $venta
     *
     * @return Socio
     */
    public function addVenta(\AppBundle\Entity\Venta $venta)
    {
        $this->ventas[] = $venta;

        return $this;
    }

    /**
     * Remove venta
     *
     * @param \AppBundle\Entity\Venta $venta
     */
    public function removeVenta(\AppBundle\Entity\Venta $venta)
    {
        $this->ventas->removeElement($venta);
    }

    /**
     * Get ventas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVentas()
    {
        return $this->ventas;
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
