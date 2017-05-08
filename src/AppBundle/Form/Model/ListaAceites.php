<?php

namespace AppBundle\Form\Model;

use Doctrine\Common\Collections\ArrayCollection;

class ListaAceites
{
    private $aceites;

    public function __construct()
    {
        $this->aceites = new ArrayCollection();
    }

    public function getAceites()
    {
        return $this->aceites;
    }

    public function setAceites(ArrayCollection $aceites)
    {
        $this->aceites = $aceites;
    }
}