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

class EntregaRepository extends EntityRepository
{
    public function getEntregasSocio(Socio $socio)
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('e')
            ->addSelect('f')
            ->addSelect('p')
            ->from('AppBundle:Entrega', 'e')
            ->join('e.finca', 'f')
            ->join('f.propietario', 'p')
            ->leftJoin('f.arrendatario', 'a')
            ->where('p = :socio')
            ->orWhere('a = :socio')
            ->setParameter('socio', $socio)
            ->getQuery()
            ->getResult();

        return $consulta;
    }

    public function getEntregasLote(Lote $lote)
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('e')
            ->addSelect('l')
            ->from('AppBundle:Entrega', 'e')
            ->join('e.lote', 'l')
            ->where('l = :lote')
            ->setParameter('lote', $lote)
            ->getQuery()
            ->getResult();

        return $consulta;
    }

    public function getEntregasSocioTemporada(Socio $socio, Temporada $temporada)
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('e')
            ->addSelect('f')
            ->addSelect('p')
            ->addSelect('t')
            ->from('AppBundle:Entrega', 'e')
            ->join('e.temporada', 't')
            ->join('e.finca', 'f')
            ->join('f.propietario', 'p')
            ->leftJoin('f.arrendatario', 'a')
            ->where('t = :temporada')
            ->andwhere('p = :socio')
            ->orwhere('a = :socio')
            ->setParameter('temporada', $temporada)
            ->setParameter('socio', $socio)
            ->getQuery()
            ->getResult();

        return $consulta;
    }

    public function getEntregasDetalle(Entrega $entrega, Socio $socio)
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('e')
            ->addSelect('f')
            ->addSelect('p')
            ->from('AppBundle:Entrega', 'e')
            ->join('e.finca', 'f')
            ->join('f.propietario', 'p')
            ->leftJoin('f.arrendatario', 'a')
            ->where('e.id = :ent')
            ->andwhere('p = :socio')
            ->orwhere('a = :socio')
            ->setParameter('ent', $entrega)
            ->setParameter('socio', $socio)
            ->getQuery()
            ->getResult();

        return $consulta;
    }
}
