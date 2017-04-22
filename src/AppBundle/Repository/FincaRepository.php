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
    public function getFincasPorLote(Lote $lote)
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('f')
            ->addSelect('f')
            ->addSelect('e')
            ->addSelect('p')
            ->addSelect('l')
            ->from('AppBundle:Finca', 'f')
            ->join('f.entregas', 'e')
            ->join('e.partida', 'p')
            ->join('p.lote', 'l')
            ->where('l = :lot')
            ->setParameter('lot', $lote)
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
            ->setParameter('propietario', $socio)
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
            ->setParameter('arrendatario', $socio)
            ->getQuery()
            ->getResult();

        return $consulta;
    }
}
