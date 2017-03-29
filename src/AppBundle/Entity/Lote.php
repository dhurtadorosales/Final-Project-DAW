<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Lote
 * @ORM\Entity()
 */
class Lote
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @var Deposito
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Deposito", mappedBy="lotes")
     * @ORM\JoinColumn(nullable=true)
     */
    private $deposito;

    /**
     * @var Linea[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Linea", mappedBy="lote")
     */
    private $lineas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->deposito = new \Doctrine\Common\Collections\ArrayCollection();
        $this->lineas = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add deposito
     *
     * @param \AppBundle\Entity\Deposito $deposito
     *
     * @return Lote
     */
    public function addDeposito(\AppBundle\Entity\Deposito $deposito)
    {
        $this->deposito[] = $deposito;

        return $this;
    }

    /**
     * Remove deposito
     *
     * @param \AppBundle\Entity\Deposito $deposito
     */
    public function removeDeposito(\AppBundle\Entity\Deposito $deposito)
    {
        $this->deposito->removeElement($deposito);
    }

    /**
     * Get deposito
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDeposito()
    {
        return $this->deposito;
    }

    /**
     * Add linea
     *
     * @param \AppBundle\Entity\Linea $linea
     *
     * @return Lote
     */
    public function addLinea(\AppBundle\Entity\Linea $linea)
    {
        $this->lineas[] = $linea;

        return $this;
    }

    /**
     * Remove linea
     *
     * @param \AppBundle\Entity\Linea $linea
     */
    public function removeLinea(\AppBundle\Entity\Linea $linea)
    {
        $this->lineas->removeElement($linea);
    }

    /**
     * Get lineas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLineas()
    {
        return $this->lineas;
    }
}
