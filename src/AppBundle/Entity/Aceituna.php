<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Aceituna
 * @ORM\Entity()
 */
class Aceituna
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
     * @var Finca[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Finca", mappedBy="variedad")
     */
    private $fincas;

    /**
     * @var Pesaje[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Pesaje", mappedBy="variedad")
     * @ORM\JoinColumn(nullable=true)
     */
    private $pesajes;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fincas = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Aceituna
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
     * @return Aceituna
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
     * Add finca
     *
     * @param \AppBundle\Entity\Finca $finca
     *
     * @return Aceituna
     */
    public function addFinca(\AppBundle\Entity\Finca $finca)
    {
        $this->fincas[] = $finca;

        return $this;
    }

    /**
     * Remove finca
     *
     * @param \AppBundle\Entity\Finca $finca
     */
    public function removeFinca(\AppBundle\Entity\Finca $finca)
    {
        $this->fincas->removeElement($finca);
    }

    /**
     * Get fincas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFincas()
    {
        return $this->fincas;
    }

    /**
     * Add pesaje
     *
     * @param \AppBundle\Entity\Pesaje $pesaje
     *
     * @return Aceituna
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
