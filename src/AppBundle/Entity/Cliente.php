<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Cliente
 * @ORM\Entity()
 */
class Cliente
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
     * @ORM\Column(type="string", length=9, nullable=true)
     */
    private $telefono;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $email;

    /**
     * @var Factura[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Factura", mappedBy="cliente")
     */
    private $facturas;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->facturas = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Cliente
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
     * @return Cliente
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
     * @return Cliente
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
     * @return Cliente
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
     * @return Cliente
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
     * @return Cliente
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
     * @return Cliente
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
     * @return Cliente
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
     * @return Cliente
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
     * @return Cliente
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
     * @return Cliente
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
     * @return Cliente
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
     * @return Cliente
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
     * @return Cliente
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
     * Add factura
     *
     * @param \AppBundle\Entity\Factura $factura
     *
     * @return Cliente
     */
    public function addFactura(\AppBundle\Entity\Factura $factura)
    {
        $this->facturas[] = $factura;

        return $this;
    }

    /**
     * Remove factura
     *
     * @param \AppBundle\Entity\Factura $factura
     */
    public function removeFactura(\AppBundle\Entity\Factura $factura)
    {
        $this->facturas->removeElement($factura);
    }

    /**
     * Get facturas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFacturas()
    {
        return $this->facturas;
    }
}
