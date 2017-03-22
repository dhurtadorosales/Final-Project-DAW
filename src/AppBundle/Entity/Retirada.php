<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Retirada
 * @ORM\Entity()
 */
class Retirada
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