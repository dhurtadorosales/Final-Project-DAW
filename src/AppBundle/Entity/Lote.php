<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Lote
 * @ORM\Entity()
 */
class Lote
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
    private $fechaFabricacion;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $cantidad;

    /**
     * @var Pesaje[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Pesaje", mappedBy="lote")
     */
    private $pesajes;

    /**
     * @var Aceite
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Aceite", inversedBy="lotes")
     */
    private $aceite;

    /**
     * @var Deposito
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Deposito", inversedBy="lotes")
     */
    private $deposito;
}