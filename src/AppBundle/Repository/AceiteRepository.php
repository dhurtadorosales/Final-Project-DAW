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

class AceiteRepository extends EntityRepository
{
    public function getAceites()
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('a')
            ->from('AppBundle:Aceite', 'a');

        return $consulta;
    }
}
