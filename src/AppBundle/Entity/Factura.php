<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Factura
 * @ORM\Entity()
 */
class Factura
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
}