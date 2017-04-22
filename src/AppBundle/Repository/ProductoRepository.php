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

class ProductoRepository extends EntityRepository
{
    public function getProductoAceiteEnvasado(Aceite $aceite)
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('p')
            ->from('AppBundle:Producto', 'p')
            ->where('p.lotes[0].aceite.id = :aceite')
            ->setParameter('aceite', $aceite)
            ->getQuery()
            ->getResult();

        return $consulta;
    }
}
