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

class UsuarioRepository extends EntityRepository
{
    public function getClientes()
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('u')
            ->from('AppBundle:Usuario', 'u')
            ->where('u.cliente = :valor')
            ->andWhere('u.activo = :activo')
            ->setParameter('valor', true)
            ->setParameter('activo', true)
            ->getQuery()
            ->getResult();

        return $consulta;
    }

    public function getEmpleados()
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('u')
            ->from('AppBundle:Usuario', 'u')
            ->where('u.empleado = :valor')
            ->andWhere('u.activo = :activo')
            ->setParameter('valor', true)
            ->setParameter('activo', true)
            ->getQuery()
            ->getResult();

        return $consulta;
    }
}
