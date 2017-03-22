<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Socio
 * @ORM\Entity()
 */
class Socio
{
    /**
     * @var int
     * @ORM\Column(type="integer)
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
     * @ORM\Column(type="date")
     */
    private $fechaBaja;
}