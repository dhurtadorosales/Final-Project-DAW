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
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $capacidad;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $contenido;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $temporada;

    /**
     * @var Amasada[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Amasada", mappedBy="lote")
     * @ORM\JoinColumn(nullable=true)
     */
    private $amasadas;

    /**
     * @var Linea[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Linea", mappedBy="lote")
     */
    private $lineas;

    /*
     * Convierte a string
     */
  /*  public function __toString()
    {
        return $this->getId() . "-" . $this->getTemporada();
    }*/


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->amasadas = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set capacidad
     *
     * @param integer $capacidad
     *
     * @return Lote
     */
    public function setCapacidad($capacidad)
    {
        $this->capacidad = $capacidad;

        return $this;
    }

    /**
     * Get capacidad
     *
     * @return integer
     */
    public function getCapacidad()
    {
        return $this->capacidad;
    }

    /**
     * Set contenido
     *
     * @param integer $contenido
     *
     * @return Lote
     */
    public function setContenido($contenido)
    {
        $this->contenido = $contenido;

        return $this;
    }

    /**
     * Get contenido
     *
     * @return integer
     */
    public function getContenido()
    {
        return $this->contenido;
    }

    /**
     * Set temporada
     *
     * @param string $temporada
     *
     * @return Lote
     */
    public function setTemporada($temporada)
    {
        $this->temporada = $temporada;

        return $this;
    }

    /**
     * Get temporada
     *
     * @return string
     */
    public function getTemporada()
    {
        return $this->temporada;
    }

    /**
     * Add amasada
     *
     * @param \AppBundle\Entity\Amasada $amasada
     *
     * @return Lote
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
