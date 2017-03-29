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
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @var Entrega[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Entrega", mappedBy="bascula")
     * @ORM\JoinColumn(nullable=true)
     */
    private $entregas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->entregas = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Add entrega
     *
     * @param \AppBundle\Entity\Entrega $entrega
     *
     * @return Bascula
     */
    public function addEntrega(\AppBundle\Entity\Entrega $entrega)
    {
        $this->entregas[] = $entrega;

        return $this;
    }

    /**
     * Remove entrega
     *
     * @param \AppBundle\Entity\Entrega $entrega
     */
    public function removeEntrega(\AppBundle\Entity\Entrega $entrega)
    {
        $this->entregas->removeElement($entrega);
    }

    /**
     * Get entregas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEntregas()
    {
        return $this->entregas;
    }
}
