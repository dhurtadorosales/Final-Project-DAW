<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Deposito
 * @ORM\Entity()
 */
class Deposito
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
    private $tipoAceite;

    /**
     * @var Amasada[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Amasada", mappedBy="deposito")
     * @ORM\JoinColumn(nullable=true)
     */
    private $amasadas;

    /**
     * @var Lote[]
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Lote", inversedBy="deposito")
     */
    private $lotes;

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
     * Set capacidad
     *
     * @param integer $capacidad
     *
     * @return Deposito
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
     * @return Deposito
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
     * Set tipoAceite
     *
     * @param string $tipoAceite
     *
     * @return Deposito
     */
    public function setTipoAceite($tipoAceite)
    {
        $this->tipoAceite = $tipoAceite;

        return $this;
    }

    /**
     * Get tipoAceite
     *
     * @return string
     */
    public function getTipoAceite()
    {
        return $this->tipoAceite;
    }

    /**
     * Add amasada
     *
     * @param \AppBundle\Entity\Amasada $amasada
     *
     * @return Deposito
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
     * Set lotes
     *
     * @param \AppBundle\Entity\Lote $lotes
     *
     * @return Deposito
     */
    public function setLotes(\AppBundle\Entity\Lote $lotes = null)
    {
        $this->lotes = $lotes;

        return $this;
    }

    /**
     * Get lotes
     *
     * @return \AppBundle\Entity\Lote
     */
    public function getLotes()
    {
        return $this->lotes;
    }
}
