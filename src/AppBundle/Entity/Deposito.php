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
    private $contendido;

    /**
     * @var float
     * @ORM\Column(type="float", precision=2)
     */
    private $precioClientes;
}