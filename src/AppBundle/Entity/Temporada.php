<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Temporada
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConsultasRepository")
 */
class Temporada
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
     * @ORM\Column(type="string", unique=true)
     */
    private $denominacion;

    /**
     * @var Lote[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Lote", mappedBy="temporada")
     * @ORM\JoinColumn(nullable=true)
     */
    private $lotes;

    /**
     * @var Liquidacion[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Liquidacion", mappedBy="temporada")
     * @ORM\JoinColumn(nullable=true)
     */
    private $liquidaciones;


    /**
     * Convierte a string
     */
    public function __toString()
    {
        return $this->getDenominacion();
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lotes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->liquidaciones = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Temporada
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
     * Add lote
     *
     * @param \AppBundle\Entity\Lote $lote
     *
     * @return Temporada
     */
    public function addLote(\AppBundle\Entity\Lote $lote)
    {
        $this->lotes[] = $lote;

        return $this;
    }

    /**
     * Remove lote
     *
     * @param \AppBundle\Entity\Lote $lote
     */
    public function removeLote(\AppBundle\Entity\Lote $lote)
    {
        $this->lotes->removeElement($lote);
    }

    /**
     * Get lotes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLotes()
    {
        return $this->lotes;
    }

    /**
     * Add liquidacione
     *
     * @param \AppBundle\Entity\Liquidacion $liquidacione
     *
     * @return Temporada
     */
    public function addLiquidacione(\AppBundle\Entity\Liquidacion $liquidacione)
    {
        $this->liquidaciones[] = $liquidacione;

        return $this;
    }

    /**
     * Remove liquidacione
     *
     * @param \AppBundle\Entity\Liquidacion $liquidacione
     */
    public function removeLiquidacione(\AppBundle\Entity\Liquidacion $liquidacione)
    {
        $this->liquidaciones->removeElement($liquidacione);
    }

    /**
     * Get liquidaciones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLiquidaciones()
    {
        return $this->liquidaciones;
    }
}
