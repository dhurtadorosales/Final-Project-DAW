<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Aceite
 * @ORM\Entity()
 */
class Aceite
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
     * @var float
     * @ORM\Column(type="float", precision=2)
     */
    private $precio;

    /**
     * @var Amasada[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Amasada", mappedBy="aceite")
     * @ORM\JoinColumn(nullable=true)
     */
    private $amasadas;

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
        $this->amasadas = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Aceite
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
     * Set precio
     *
     * @param float $precio
     *
     * @return Aceite
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get precio
     *
     * @return float
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Add amasada
     *
     * @param \AppBundle\Entity\Amasada $amasada
     *
     * @return Aceite
     */
    public function addAmasada(\AppBundle\Entity\Amasada $amasada)
    {
        $this->amasadas[] = $amasada;

        return $this;
    }

    /**
     * Remove amasada
     *
     * @param \AppBundle\Entity\Amasada $amasada
     */
    public function removeAmasada(\AppBundle\Entity\Amasada $amasada)
    {
        $this->amasadas->removeElement($amasada);
    }

    /**
     * Get amasadas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAmasadas()
    {
        return $this->amasadas;
    }
}
