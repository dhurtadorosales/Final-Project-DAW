<?php

namespace AppBundle\Form\Model;

use Doctrine\Common\Collections\ArrayCollection;

class ListaVariedades
{
    private $aceitunas;

    public function __construct()
    {
        $this->aceitunas = new ArrayCollection();
    }

    public function getAceituras()
    {
        return $this->aceitunas;
    }

    public function setAceitunas(ArrayCollection $aceitunas)
    {
        $this->aceitunas = $aceitunas;
    }
}