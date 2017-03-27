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
     * @var Pesaje[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Pesaje", mappedBy="bascula")
     * @ORM\JoinColumn(nullable=true)
     */
    private $pesajes;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pesajes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add pesaje
     *
     * @param \AppBundle\Entity\Pesaje $pesaje
     *
     * @return Bascula
     */
    public function addPesaje(\AppBundle\Entity\Pesaje $pesaje)
    {
        $this->pesajes[] = $pesaje;

        return $this;
    }

    /**
     * Remove pesaje
     *
     * @param \AppBundle\Entity\Pesaje $pesaje
     */
    public function removePesaje(\AppBundle\Entity\Pesaje $pesaje)
    {
        $this->pesajes->removeElement($pesaje);
    }

    /**
     * Get pesajes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPesajes()
    {
        return $this->pesajes;
    }
}
