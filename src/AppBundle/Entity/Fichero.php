<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Fichero
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FicheroRepository")
 */
class Fichero
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Inserta el fichero con las entregas de hoy")
     */
    private $entregas;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set entregas
     *
     * @param string $entregas
     *
     * @return Fichero
     */
    public function setEntregas($entregas)
    {
        $this->entregas = $entregas;

        return $this;
    }

    /**
     * Get entregas
     *
     * @return string
     */
    public function getEntregas()
    {
        return $this->entregas;
    }
}
