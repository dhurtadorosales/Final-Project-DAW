<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Linea
 * @ORM\Entity()
 */
class Linea
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
    private $cantidad;

    /**
     * @var Factura
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Factura", inversedBy="lineas")
     * @ORM\JoinColumn(nullable=true)
     */
    private $factura;

    /**
     * @var Retirada
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Retirada", inversedBy="lineas")
     * @ORM\JoinColumn(nullable=true)
     */
    private $retirada;

    /**
     * @var Deposito
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Deposito", inversedBy="lineas")
     */
    private $aceite;
}