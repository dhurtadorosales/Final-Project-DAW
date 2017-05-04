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

class FincaRepository extends EntityRepository
{
    public function getFincas()
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('f')
            ->from('AppBundle:Finca', 'f')
            ->where('f.activa = :activa')
            ->setParameter('activa', true)
            ->getQuery()
            ->getResult();

        return $consulta;
    }

    public function getFincasPorLote(Lote $lote)
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('f')
            ->addSelect('f')
            ->addSelect('e')
            ->addSelect('l')
            ->from('AppBundle:Finca', 'f')
            ->join('f.entregas', 'e')
            ->join('e.lote', 'l')
            ->where('l = :lot')
            ->andWhere('f.activa = :activa')
            ->setParameter('lot', $lote)
            ->setParameter('activa', true)
            ->getQuery()
            ->getResult();

        return $consulta;
    }

    public function getFincasPorPropietario(Socio $socio)
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('f')
            ->addSelect('p')
            ->from('AppBundle:Finca', 'f')
            ->join('f.propietario', 'p')
            ->where('p = :propietario')
            ->andWhere('f.activa = :activa')
            ->setParameter('propietario', $socio)
            ->setParameter('activa', true)
            ->getQuery()
            ->getResult();

        return $consulta;
    }

    public function getFincasPorArrendatario(Socio $socio)
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('f')
            ->addSelect('a')
            ->from('AppBundle:Finca', 'f')
            ->join('f.arrendatario', 'a')
            ->where('a = :arrendatario')
            ->andWhere('f.activa = :activa')
            ->setParameter('arrendatario', $socio)
            ->setParameter('activa', true)
            ->getQuery()
            ->getResult();

        return $consulta;
    }
}
