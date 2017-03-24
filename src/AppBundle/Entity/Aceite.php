<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Aceite
 * @ORM\Entity()
 */
class Aceite
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
     * @ORM\Column(type="string", unique=true)
     */
    private $denominacion;

    /**
     * @var float
     * @ORM\Column(type="float", precision=2)
     */
    private $precioSocios;

    /**
     * @var float
     * @ORM\Column(type="float", precision=2)
     */
    private $precioClientes;

    /**
     * @var Lote[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Lote", mappedBy="aceite")
     * @ORM\JoinColumn(nullable=true)
     */
    private $lotes;
}