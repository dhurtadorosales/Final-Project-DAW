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

class LiquidacionRepository extends EntityRepository
{
    public function getLiquidacionDetalle(Socio $socio, Temporada $temporada)
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('l')
            ->addSelect('s')
            ->from('AppBundle:Liquidacion', 'l')
            ->join('l.socio', 's')
            ->where('s = :socio')
            ->andWhere('l.temporada = :temporada')
            ->setParameter('socio', $socio)
            ->setParameter('temporada', $temporada)
            ->getQuery()
            ->getResult();

        return $consulta;
    }

    public function getLiquidacionTemporada(Temporada $temporada)
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('l')
            ->addSelect('t')
            ->from('AppBundle:Liquidacion', 'l')
            ->join('l.temporada', 't')
            ->where('t = :temporada')
            ->setParameter('temporada', $temporada)
            ->getQuery()
            ->getResult();

        return $consulta;
    }
}
