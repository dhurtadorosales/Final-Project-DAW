<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class Usuario
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UsuarioRepository")
 */
class Usuario implements AdvancedUserInterface
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
     * @Assert\NotBlank(message="Este campo es obligatorio")
     */
    private $nif;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Este campo es obligatorio")
     */
    private $clave;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Este campo es obligatorio")
     * @Assert\Regex("/^[A-Z a-zÑñáéíóúÁÉÍÓÚ , . /]*$/", message="Formato no válido")
     */
    private $nombre;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank(message="Este campo es obligatorio")
     * @Assert\Regex("/^[A-Z a-zÑñáéíóúÁÉÍÓÚ]*$/", message="Formato no válido")
     */
    private $apellidos;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Este campo es obligatorio")
     * @Assert\Regex("/^[A-Z a-zÑñáéíóúÁÉÍÓÚ , . /]*$/", message="Formato no válido")
     */
    private $direccion;

    /**
     * @var string
     * @ORM\Column(type="string", length=5)
     * @Assert\NotBlank(message="Este campo es obligatorio")
     * @Assert\Regex("/^[0-9]{5}$/", message="Formato no válido")
     */
    private $codigoPostal;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Este campo es obligatorio")
     * @Assert\Regex("/^[A-Z a-zÑñáéíóúÁÉÍÓÚ]*$/", message="Formato no válido")
     */
    private $localidad;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Este campo es obligatorio")
     * @Assert\Regex("/^[A-Z a-zÑñáéíóúÁÉÍÓÚ]*$/", message="Formato no válido")
     */
    private $provincia;

    /**
     * @var string
     * @ORM\Column(type="string", length=9, nullable=true)
     * @Assert\Regex("/^[0-9]{9}$/", message="Formato no válido")
     */
    private $telefono;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Email(message="Formato no válido")
     */
    private $email;

    /**
     * @var float
     * @ORM\Column(type="float", precision=2)
     * @Assert\NotBlank(message="Este campo es obligatorio")
     * @Assert\Regex("/^[0-9]+(\.[0-9]+)?$/")
     */
    private $descuento;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $administrador;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $empleado;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $comercial;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $dependiente;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $encargado;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $cliente;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $rolSocio;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $activo;

    /**
     * @var Socio
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Socio", inversedBy="usuario")
     * @ORM\JoinColumn(nullable=true)
     */
    private $socio;

    /**
     * @var Venta[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Venta", mappedBy="usuario")
     * @ORM\JoinColumn(nullable=true)
     */
    private $ventas;

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
        $this->ventas = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Usuario
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
     * Set clave
     *
     * @param string $clave
     *
     * @return Usuario
     */
    public function setClave($clave)
    {
        $this->clave = $clave;

        return $this;
    }

    /**
     * Get clave
     *
     * @return string
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Usuario
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
     * @return Usuario
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
     * Set direccion
     *
     * @param string $direccion
     *
     * @return Usuario
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set codigoPostal
     *
     * @param string $codigoPostal
     *
     * @return Usuario
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
     * @return Usuario
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
     * @return Usuario
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
     * @return Usuario
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
     * @return Usuario
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
     * Set descuento
     *
     * @param float $descuento
     *
     * @return Usuario
     */
    public function setDescuento($descuento)
    {
        $this->descuento = $descuento;

        return $this;
    }

    /**
     * Get descuento
     *
     * @return float
     */
    public function getDescuento()
    {
        return $this->descuento;
    }

    /**
     * Set administrador
     *
     * @param boolean $administrador
     *
     * @return Usuario
     */
    public function setAdministrador($administrador)
    {
        $this->administrador = $administrador;

        return $this;
    }

    /**
     * Get administrador
     *
     * @return boolean
     */
    public function getAdministrador()
    {
        return $this->administrador;
    }

    /**
     * Set empleado
     *
     * @param boolean $empleado
     *
     * @return Usuario
     */
    public function setEmpleado($empleado)
    {
        $this->empleado = $empleado;

        return $this;
    }

    /**
     * Get empleado
     *
     * @return boolean
     */
    public function getEmpleado()
    {
        return $this->empleado;
    }

    /**
     * Set comercial
     *
     * @param boolean $comercial
     *
     * @return Usuario
     */
    public function setComercial($comercial)
    {
        $this->comercial = $comercial;

        return $this;
    }

    /**
     * Get comercial
     *
     * @return boolean
     */
    public function getComercial()
    {
        return $this->comercial;
    }

    /**
     * Set dependiente
     *
     * @param boolean $dependiente
     *
     * @return Usuario
     */
    public function setDependiente($dependiente)
    {
        $this->dependiente = $dependiente;

        return $this;
    }

    /**
     * Get dependiente
     *
     * @return boolean
     */
    public function getDependiente()
    {
        return $this->dependiente;
    }

    /**
     * Set encargado
     *
     * @param boolean $encargado
     *
     * @return Usuario
     */
    public function setEncargado($encargado)
    {
        $this->encargado = $encargado;

        return $this;
    }

    /**
     * Get encargado
     *
     * @return boolean
     */
    public function getEncargado()
    {
        return $this->encargado;
    }

    /**
     * Set cliente
     *
     * @param boolean $cliente
     *
     * @return Usuario
     */
    public function setCliente($cliente)
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente
     *
     * @return boolean
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set rolSocio
     *
     * @param boolean $rolSocio
     *
     * @return Usuario
     */
    public function setRolSocio($rolSocio)
    {
        $this->rolSocio = $rolSocio;

        return $this;
    }

    /**
     * Get rolSocio
     *
     * @return boolean
     */
    public function getRolSocio()
    {
        return $this->rolSocio;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Usuario
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
     * Set socio
     *
     * @param \AppBundle\Entity\Socio $socio
     *
     * @return Usuario
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
     * Add venta
     *
     * @param \AppBundle\Entity\Venta $venta
     *
     * @return Usuario
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
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        $roles = ['ROLE_USUARIO'];

        if ($this->getAdministrador()) {
            $roles[] = 'ROLE_ADMINISTRADOR';
        }

        if ($this->getComercial()) {
            $roles[] = 'ROLE_COMERCIAL';
        }

        if ($this->getDependiente()) {
            $roles[] = 'ROLE_DEPENDIENTE';
        }

        if ($this->getEncargado()) {
            $roles[] = 'ROLE_ENCARGADO';
        }

        if ($this->getRolSocio()) {
            $roles[] = 'ROLE_SOCIO';
        }

        if ($this->getCliente()) {
            $roles[] = 'ROLE_CLIENTE';
        }

        return $roles;
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        return $this->getClave();
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->getNif();
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * Checks whether the user's account has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw an AccountExpiredException and prevent login.
     *
     * @return bool true if the user's account is non expired, false otherwise
     *
     * @see AccountExpiredException
     */
    public function isAccountNonExpired()
    {
        return true;
    }

    /**
     * Checks whether the user is locked.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a LockedException and prevent login.
     *
     * @return bool true if the user is not locked, false otherwise
     *
     * @see LockedException
     */
    public function isAccountNonLocked()
    {
        return true;
    }

    /**
     * Checks whether the user's credentials (password) has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a CredentialsExpiredException and prevent login.
     *
     * @return bool true if the user's credentials are non expired, false otherwise
     *
     * @see CredentialsExpiredException
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * Checks whether the user is enabled.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a DisabledException and prevent login.
     *
     * @return bool true if the user is enabled, false otherwise
     *
     * @see DisabledException
     */
    public function isEnabled()
    {
        return $this->getActivo();
    }
}
