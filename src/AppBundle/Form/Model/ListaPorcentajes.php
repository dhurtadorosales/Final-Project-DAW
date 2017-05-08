<?php

namespace AppBundle\Form\Model;

use Doctrine\Common\Collections\ArrayCollection;

class ListaPorcentajes
{
    private $porcentajes;

    public function __construct()
    {
        $this->porcentajes = new ArrayCollection();
    }

    public function getPorcentajes()
    {
        return $this->porcentajes;
    }

    public function setPorcentajes(ArrayCollection $porcentajes)
    {
        $this->porcentajes = $porcentajes;
    }
}