<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Aceite;
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

    public function getLotesTemporadaNoNulosQuery(Temporada $temporada, Aceite $aceite)
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('l')
            ->addSelect('t')
            ->addSelect('a')
            ->from('AppBundle:Lote', 'l')
            ->join('l.temporada', 't')
            ->join('l.aceite', 'a')
            ->where('t = :temporada')
            ->andwhere('a = :aceite')
            ->andWhere('l.cantidad != :cantidad')
            ->setParameter('temporada', $temporada)
            ->setParameter('aceite', $aceite)
            ->setParameter('cantidad', 0);

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

    public function getLoteAceite(Aceite $aceite)
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('l')
            ->from('AppBundle:Lote', 'l')
            ->where('l.aceite = :aceite')
            ->andWhere('l.stock != :stock')
            ->setParameter('aceite', $aceite)
            ->setParameter('stock', 0)
            ->getQuery()
            ->getResult();

        return $consulta;
    }
}
