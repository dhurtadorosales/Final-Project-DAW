<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Deposito
 * @ORM\Entity()
 */
class Deposito
{
    /**
     * @var int
     * @ORM\Column(type="integer)
     * @ORM\Id()
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $capacidad;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $contenido;

    /**
     * @var Lote[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Lote", mappedBy="deposito")
     * @ORM\JoinColumn(nullable=true)
     */
    private $lotes;

    /**
     * @var Linea[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Linea", mappedBy="aceite")
     */
    private $lineas;
}