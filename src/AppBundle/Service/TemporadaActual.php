<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TemporadaActual extends Controller
{
    protected $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function temporadaActualAction()
    {
        $em = $this->entityManager;

        //Obtención de todas las temporadas
        $temporadas = $em->getRepository('AppBundle:Temporada')
                ->findAll();

        //Nos quedamos con la última
        $temporada = $temporadas[sizeof($temporadas) - 1];

        return $temporada;
    }
}