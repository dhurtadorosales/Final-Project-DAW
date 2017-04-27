<?php

namespace AppBundle\Form\Model;

use Doctrine\Common\Collections\ArrayCollection;

class ListaProductos
{
    private $productos;

    public function __construct()
    {
        $this->productos = new ArrayCollection();
    }

    public function getProductos()
    {
        return $this->productos;
    }

    public function setProductos(ArrayCollection $productos)
    {
        $this->productos = $productos;
    }
}