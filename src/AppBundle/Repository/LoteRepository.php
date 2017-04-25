<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Lote;
use AppBundle\Entity\Temporada;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class LoteRepository extends EntityRepository
{
    public function getLotesTemporada(Temporada $temporada)
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('l')
            ->addSelect('t')
            ->from('AppBundle:Lote', 'l')
            ->join('l.temporada', 't')
            ->where('t = :temporada')
            ->setParameter('temporada', $temporada)
            ->getQuery()
            ->getResult();

        return $consulta;
    }

    public function getLotesTemporadaNoNulos(Temporada $temporada)
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('l')
            ->addSelect('t')
            ->from('AppBundle:Lote', 'l')
            ->join('l.temporada', 't')
            ->where('t = :temporada')
            ->andWhere('l.cantidad != :cantidad')
            ->setParameter('temporada', $temporada)
            ->setParameter('cantidad', 0)
            ->getQuery()
            ->getResult();

        return $consulta;
    }

    public function getLoteUnico(Lote $lote)
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('l')
            ->from('AppBundle:Lote', 'l')
            ->where('l.id = :lot')
            ->setParameter('lot', $lote)
            ->getQuery()
            ->getResult();

        return $consulta;
    }
}
