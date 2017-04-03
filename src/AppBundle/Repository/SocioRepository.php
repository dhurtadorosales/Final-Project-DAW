<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class SocioRepository extends EntityRepository
{
    public function getSocios()
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('s')
            ->from('AppBundle:Socio', 's')
            ->getQuery()
            ->getResult();

        return $consulta;
    }

    public function getPlantasBySocio()
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('SUM(f.numPlantas)')
            ->from('AppBundle:Finca', 'f')
            ->groupBy('f.propietario')
            ->getQuery()
            ->getScalarResult();

        return $consulta;
    }
}
