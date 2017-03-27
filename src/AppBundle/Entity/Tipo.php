<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Tipo
 * @ORM\Entity()
 */
class Tipo
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
     */
    private $denominacion;

    /**
     * @var float
     * @ORM\Column(type="float", precision=2)
     */
    private $penalizacion;

    /**
     * @var Pesaje[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Pesaje", mappedBy="tipo")
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
     * Set denominacion
     *
     * @param string $denominacion
     *
     * @return Tipo
     */
    public function setDenominacion($denominacion)
    {
        $this->denominacion = $denominacion;

        return $this;
    }

    /**
     * Get denominacion
     *
     * @return string
     */
    public function getDenominacion()
    {
        return $this->denominacion;
    }

    /**
     * Set penalizacion
     *
     * @param float $penalizacion
     *
     * @return Tipo
     */
    public function setPenalizacion($penalizacion)
    {
        $this->penalizacion = $penalizacion;

        return $this;
    }

    /**
     * Get penalizacion
     *
     * @return float
     */
    public function getPenalizacion()
    {
        return $this->penalizacion;
    }

    /**
     * Add pesaje
     *
     * @param \AppBundle\Entity\Pesaje $pesaje
     *
     * @return Tipo
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
