<?php

namespace AppBundle\Form\Model;

use Doctrine\Common\Collections\ArrayCollection;

class ListaLineas
{
    private $lineas;

    public function __construct()
    {
        $this->lineas = new ArrayCollection();
    }

    public function getLineas()
    {
        return $this->lineas;
    }

    public function setAceites(ArrayCollection $lineas)
    {
        $this->lineas = $lineas;
    }
}