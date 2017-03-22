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
     * @ORM\Column(type="integer)
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
}