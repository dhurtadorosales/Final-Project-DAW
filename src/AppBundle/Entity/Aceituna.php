<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Aceituna
 * @ORM\Entity()
 */
class Aceituna
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
    private $precio;

    /**
     * @var float
     * @ORM\Column(type="float", precision=2)
     */
    private $precioEcologico;
}