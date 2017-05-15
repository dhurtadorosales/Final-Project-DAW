<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Temporada
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TemporadaRepository")
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
     * @var Entrega[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Entrega", mappedBy="temporada")
     * @ORM\JoinColumn(nullable=true)
     */
    private $entregas;

    /**
     * @var Venta[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Venta", mappedBy="temporada")
     * @ORM\JoinColumn(nullable=true)
     */
    private $ventas;

    /**
     * @var Movimiento[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Movimiento", mappedBy="temporada")
     * @ORM\JoinColumn(nullable=true)
     */
    private $movimientos;

    /**
     * @var Aviso[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Aviso", mappedBy="temporada")
     * @ORM\JoinColumn(nullable=true)
     */
    private $avisos;


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
        $this->entregas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ventas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->movimientos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->avisos = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Add entrega
     *
     * @param \AppBundle\Entity\Entrega $entrega
     *
     * @return Temporada
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
     * Add venta
     *
     * @param \AppBundle\Entity\Venta $venta
     *
     * @return Temporada
     */
    public function addVenta(\AppBundle\Entity\Venta $venta)
    {
        $this->ventas[] = $venta;

        return $this;
    }

    /**
     * Remove venta
     *
     * @param \AppBundle\Entity\Venta $venta
     */
    public function removeVenta(\AppBundle\Entity\Venta $venta)
    {
        $this->ventas->removeElement($venta);
    }

    /**
     * Get ventas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVentas()
    {
        return $this->ventas;
    }

    /**
     * Add movimiento
     *
     * @param \AppBundle\Entity\Movimiento $movimiento
     *
     * @return Temporada
     */
    public function addMovimiento(\AppBundle\Entity\Movimiento $movimiento)
    {
        $this->movimientos[] = $movimiento;

        return $this;
    }

    /**
     * Remove movimiento
     *
     * @param \AppBundle\Entity\Movimiento $movimiento
     */
    public function removeMovimiento(\AppBundle\Entity\Movimiento $movimiento)
    {
        $this->movimientos->removeElement($movimiento);
    }

    /**
     * Get movimientos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMovimientos()
    {
        return $this->movimientos;
    }

    /**
     * Add aviso
     *
     * @param \AppBundle\Entity\Aviso $aviso
     *
     * @return Temporada
     */
    public function addAviso(\AppBundle\Entity\Aviso $aviso)
    {
        $this->avisos[] = $aviso;

        return $this;
    }

    /**
     * Remove aviso
     *
     * @param \AppBundle\Entity\Aviso $aviso
     */
    public function removeAviso(\AppBundle\Entity\Aviso $aviso)
    {
        $this->avisos->removeElement($aviso);
    }

    /**
     * Get avisos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAvisos()
    {
        return $this->avisos;
    }
}
