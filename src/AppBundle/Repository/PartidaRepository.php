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

class PartidaRepository extends EntityRepository
{
    public function getPartidasLote(Lote $lote)
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('p')
            ->addSelect('l')
            ->from('AppBundle:Partida', 'p')
            ->join('p.lote', 'l')
            ->where('l = :lote')
            ->setParameter('lote', $lote)
            ->getQuery()
            ->getResult();

        return $consulta;
    }
}
