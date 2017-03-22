<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class Usuario
 * @ORM\Entity()
 */
class Usuario implements UserInterface
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
     * @ORM\Column(type="string", length=9, unique=true)
     * @Assert\NotBlank()
     */
    private $nif;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $clave;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $administrador;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $gerente;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $comercial;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $socio;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $cliente;
}