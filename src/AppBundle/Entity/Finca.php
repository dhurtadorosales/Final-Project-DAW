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
}