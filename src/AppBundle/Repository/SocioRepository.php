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

class SocioRepository extends EntityRepository
{
    public function getSocios()
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('s')
            ->from('AppBundle:Socio', 's')
            ->where('s.activo = :activo')
            ->setParameter('activo', true)
            ->getQuery()
            ->getResult();

        return $consulta;
    }

    public function getSociosBaja()
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('s')
            ->from('AppBundle:Socio', 's')
            ->where('s.activo = :activo')
            ->setParameter('activo', false)
            ->getQuery()
            ->getResult();

        return $consulta;
    }

    public function buscarSocios($parametro)
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('s')
            ->addSelect('u')
            ->from('AppBundle:Socio', 's')
            ->join('s.usuario', 'u')
            ->where('s.activo = :activo')
            ->andWhere('u.nombre LIKE :parametro')
            ->orWhere('u.apellidos LIKE :parametro')
            ->orWhere('u.nif LIKE :parametro')
            ->setParameter('activo', true)
            ->setParameter('parametro', '%' . $parametro . '%')
            ->getQuery()
            ->getResult();

        return $consulta;
    }

    public function buscarSociosBaja($parametro)
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('s')
            ->select('u')
            ->from('AppBundle:Socio', 's')
            ->join('s.usuario', 'u')
            ->where('s.activo = :activo')
            ->andWhere('u.nombre LIKE :parametro')
            ->orWhere('u.apellidos LIKE :parametro')
            ->orWhere('u.nif LIKE :parametro')
            ->setParameter('activo', false)
            ->setParameter('parametro', '%' . $parametro . '%')
            ->getQuery()
            ->getResult();

        return $consulta;
    }
}
