<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Aceite;
use AppBundle\Entity\Cliente;
use AppBundle\Entity\Entrega;
use AppBundle\Entity\Envase;
use AppBundle\Entity\Lote;
use AppBundle\Entity\Partida;
use AppBundle\Entity\Socio;
use AppBundle\Entity\Temporada;
use AppBundle\Entity\Venta;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class TemporadaRepository extends EntityRepository
{
    public function getTemporadas()
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('t')
            ->from('AppBundle:Temporada', 't')
            ->where('t.denominacion != :denominacion')
            ->setParameter('denominacion', '00/00')
            ->getQuery()
            ->getResult();

        return $consulta;
    }
}
