<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class Usuario
 * @ORM\Entity()
 */
class Usuario
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
    public function getSocio()
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
    public function getCliente()
    {
        return $this->cliente;
    }
}
