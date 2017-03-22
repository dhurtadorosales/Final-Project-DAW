<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Bascula
 * @ORM\Entity()
 */
class Bascula
{
    /**
     * @var int
     * @ORM\Column(type="integer)
     * @ORM\Id()
     * @ORM\GeneratedValue()
     */
    private $id;
}