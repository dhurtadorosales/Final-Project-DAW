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

class AvisoRepository extends EntityRepository
{
    public function getNumeroAvisos()
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('COUNT(a)')
            ->from('AppBundle:Aviso', 'a')
            ->getQuery()
            ->getSingleScalarResult();

        return $consulta;
    }

    public function getAvisosTemporada(Temporada $temporada)
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('a')
            ->from('AppBundle:Aviso', 'a')
            ->where('a.temporada = :temporada')
            ->setParameter('temporada', $temporada)
            ->getQuery()
            ->getResult();

        return $consulta;
    }
}
