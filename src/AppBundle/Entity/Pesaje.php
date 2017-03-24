<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Pesaje
 * @ORM\Entity()
 */
class Pesaje
{
    /**
     * @var int
     * @ORM\Column(type="integer)
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
     * @var Tipo
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Tipo", inversedBy="pesajes")
     */
    private $tipo;

    /**
     * @var Temporada
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Temporada", inversedBy="pesajes")
     */
    private $temporada;

    /**
     * @var Bascula
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Bascula, inversedBy="pesajes")
     */
    private $bascula;

    /**
     * @var Finca
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Finca", inversedBy="pesajes")
     */
    private $finca;

}