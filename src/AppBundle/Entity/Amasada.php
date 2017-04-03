<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Amasada
 * @ORM\Entity()
 */
class Amasada
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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cantidad;

    /**
     * @var Entrega[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Entrega", mappedBy="amasada")
     * @ORM\JoinColumn(nullable=true)
     */
    private $entregas;

    /**
     * @var Aceite
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Aceite", inversedBy="amasadas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $aceite;

    /**
     * @var Lote
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Lote", inversedBy="amasadas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $lote;


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
     * Set fechaFabricacion
     *
     * @param \DateTime $fechaFabricacion
     *
     * @return Amasada
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
     * @return Amasada
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
     * Add entrega
     *
     * @param \AppBundle\Entity\Entrega $entrega
     *
     * @return Amasada
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

    /**
     * Set aceite
     *
     * @param \AppBundle\Entity\Aceite $aceite
     *
     * @return Amasada
     */
    public function setAceite(\AppBundle\Entity\Aceite $aceite)
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
     * Set lote
     *
     * @param \AppBundle\Entity\Lote $lote
     *
     * @return Amasada
     */
    public function setLote(\AppBundle\Entity\Lote $lote)
    {
        $this->lote = $lote;

        return $this;
    }

    /**
     * Get lote
     *
     * @return \AppBundle\Entity\Lote
     */
    public function getLote()
    {
        return $this->lote;
    }
}
