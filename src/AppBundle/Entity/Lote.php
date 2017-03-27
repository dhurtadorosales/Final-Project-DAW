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
     * @var \DateTime
     * @ORM\Column(type="date")
     */
    private $fechaFabricacion;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $cantidad;

    /**
     * @var Pesaje[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Pesaje", mappedBy="lote")
     */
    private $pesajes;

    /**
     * @var Aceite
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Aceite", inversedBy="lotes")
     */
    private $aceite;

    /**
     * @var Deposito
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Deposito", inversedBy="lotes")
     */
    private $deposito;
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
     * Set fechaFabricacion
     *
     * @param \DateTime $fechaFabricacion
     *
     * @return Lote
     */
    public function setFechaFabricacion($fechaFabricacion)
    {
        $this->fechaFabricacion = $fechaFabricacion;

        return $this;
    }

    /**
     * Get fechaFabricacion
     *
     * @return \DateTime
     */
    public function getFechaFabricacion()
    {
        return $this->fechaFabricacion;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     *
     * @return Lote
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Add pesaje
     *
     * @param \AppBundle\Entity\Pesaje $pesaje
     *
     * @return Lote
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

    /**
     * Set aceite
     *
     * @param \AppBundle\Entity\Aceite $aceite
     *
     * @return Lote
     */
    public function setAceite(\AppBundle\Entity\Aceite $aceite = null)
    {
        $this->aceite = $aceite;

        return $this;
    }

    /**
     * Get aceite
     *
     * @return \AppBundle\Entity\Aceite
     */
    public function getAceite()
    {
        return $this->aceite;
    }

    /**
     * Set deposito
     *
     * @param \AppBundle\Entity\Deposito $deposito
     *
     * @return Lote
     */
    public function setDeposito(\AppBundle\Entity\Deposito $deposito = null)
    {
        $this->deposito = $deposito;

        return $this;
    }

    /**
     * Get deposito
     *
     * @return \AppBundle\Entity\Deposito
     */
    public function getDeposito()
    {
        return $this->deposito;
    }
}
