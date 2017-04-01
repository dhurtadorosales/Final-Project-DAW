<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class SocioRepository extends EntityRepository
{
    public function indexAction()
    {
        /** @var EntityManager $em */
        $em=$this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('s')
            ->from('AppBundle:Socio', 's')
            ->getQuery()
            ->getResult();

        return $consulta;
    }
}
