<?php

namespace AppBundle\Form\Model;

use Doctrine\Common\Collections\ArrayCollection;

class ListaLotes
{
    private $lotes;

    public function __construct()
    {
        $this->lotes = new ArrayCollection();
    }

    public function getLotes()
    {
        return $this->lotes;
    }

    public function setLotes(ArrayCollection $lotes)
    {
        $this->lotes = $lotes;
    }
}