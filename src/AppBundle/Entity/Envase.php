<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextFactoryInterface;

/**
 * Class Envase
 * @ORM\Entity()
 * @Assert\Callback
 */
class Envase
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
     * @Assert\NotBlank(message="Este campo es obligatorio")
     * @Assert\Regex("/^[A-Z a-zÑñáéíóúÁÉÍÓÚ]*$/", message="Formato no válido")
     */
    private $denominacion;

    /**
     * @var float
     * @ORM\Column(type="float", precision=2)
     * @Assert\NotBlank(message="Este campo es obligatorio")
     * @Assert\Regex("/^[0-9]+(\.[0-9]+)?$/")
     */
    private $capacidadLitros;

    /**
     * @var Producto[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Producto", mappedBy="envase")
     * @ORM\JoinColumn(nullable=true)
     */
    private $productos;

    public function validate(ExecutionContextFactoryInterface $context)
    {

    }

    /**
     * Convierte a string
     */
    public function __toString()
    {
        return $this->getDenominacion() . ' ' . $this->getCapacidadLitros() . ' L';
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->productos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Envase
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
     * Set capacidadLitros
     *
     * @param float $capacidadLitros
     *
     * @return Envase
     */
    public function setCapacidadLitros($capacidadLitros)
    {
        $this->capacidadLitros = $capacidadLitros;

        return $this;
    }

    /**
     * Get capacidadLitros
     *
     * @return float
     */
    public function getCapacidadLitros()
    {
        return $this->capacidadLitros;
    }


    /**
     * Add producto
     *
     * @param \AppBundle\Entity\Producto $producto
     *
     * @return Envase
     */
    public function addProducto(\AppBundle\Entity\Producto $producto)
    {
        $this->productos[] = $producto;

        return $this;
    }

    /**
     * Remove producto
     *
     * @param \AppBundle\Entity\Producto $producto
     */
    public function removeProducto(\AppBundle\Entity\Producto $producto)
    {
        $this->productos->removeElement($producto);
    }

    /**
     * Get productos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductos()
    {
        return $this->productos;
    }
}
