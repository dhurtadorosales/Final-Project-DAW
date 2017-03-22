<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Class Temporada
 * @ORM\Entity()
 */
class Temporada
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
     * @ORM\Column(type="", length=4)
     */
    private $inicio;

    /**
     * @var string
     * @ORM\Column(type="string", length=4)
     */
    private $fin;
}