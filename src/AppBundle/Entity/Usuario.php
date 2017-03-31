<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class Usuario
 * @ORM\Entity()
 */
class Usuario implements UserInterface
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
     * @Assert\NotBlank()
     */
    private $nif;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $clave;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $administrador;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $empleado;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $comercial;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $dependiente;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $encargado;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $socio;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $cliente;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $usuario;


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
    public function isAdministrador()
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
    public function isEmpleado()
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
    public function isComercial()
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
    public function isDependiente()
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
    public function isEncargado()
    {
        return $this->encargado;
    }

    /**
     * Set socio
     *
     * @param boolean $socio
     *
     * @return Usuario
     */
    public function setSocio($socio)
    {
        $this->socio = $socio;

        return $this;
    }

    /**
     * Get socio
     *
     * @return boolean
     */
    public function isSocio()
    {
        return $this->socio;
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
    public function isCliente()
    {
        return $this->cliente;
    }

    /**
     * Set usuario
     *
     * @param boolean $usuario
     *
     * @return Usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return boolean
     */
    public function isUsuario()
    {
        return $this->usuario;
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

        if ($this->isAdministrador()) {
            $roles[] = 'ROLE_ADMINISTRADOR';
        }

        if ($this->isComercial()) {
            $roles[] = 'ROLE_COMERCIAL';
        }

        if ($this->isDependiente()) {
            $roles[] = 'ROLE_DEPENDIENTE';
        }

        if ($this->isEncargado()) {
            $roles[] = 'ROLE_ENCARGADO';
        }

        if ($this->isSocio()) {
            $roles[] = 'ROLE_SOCIO';
        }

        if ($this->isCliente()) {
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
}
