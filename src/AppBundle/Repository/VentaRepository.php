<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Socio;
use AppBundle\Entity\Temporada;
use AppBundle\Entity\Usuario;
use AppBundle\Entity\Venta;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class VentaRepository extends EntityRepository
{
    public function getLineasVenta(Venta $venta)
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('l')
            ->from('AppBundle:Linea', 'l')
            ->where('l.venta = :venta')
            ->setParameter('venta', $venta)
            ->getQuery()
            ->getResult();

        return $consulta;
    }

    public function getVenta(Venta $venta)
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('v')
            ->from('AppBundle:Venta', 'v')
            ->where('v = :venta')
            ->setParameter('venta', $venta)
            ->getQuery()
            ->getResult();

        return $consulta;
    }

    public function getVentasAnio($anio)
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('COUNT(v)')
            ->from('AppBundle:Venta', 'v')
            ->where('v.fecha > :fechaInicio')
            ->andWhere('v.fecha < :fechaFin')
            ->setParameter('fechaInicio', new \DateTime(($anio - 1) . "-12-31"))
            ->setParameter('fechaFin', new \DateTime(($anio + 1) . "-01-01"))
            ->getQuery()
            ->getSingleScalarResult();

        return $consulta;
    }

    public function getVentasTemporada(Temporada $temporada)
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('v')
            ->addSelect('t')
            ->from('AppBundle:Venta', 'v')
            ->join('v.temporada', 't')
            ->where('t = :temporada')
            ->setParameter('temporada', $temporada)
            ->getQuery()
            ->getResult();

        return $consulta;
    }

    public function getVentasTemporadaSocio(Temporada $temporada, Socio $socio)
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('v')
            ->addSelect('t')
            ->addSelect('u')
            ->addSelect('s')
            ->from('AppBundle:Venta', 'v')
            ->join('v.temporada', 't')
            ->join('v.usuario', 'u')
            ->join('u.socio', 's')
            ->where('t = :temporada')
            ->andWhere('s = :socio')
            ->setParameter('temporada', $temporada)
            ->setParameter('socio', $socio)
            ->getQuery()
            ->getResult();

        return $consulta;
    }

    public function getVentasCliente(Usuario $usuario)
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('v')
            ->addSelect('c')
            ->from('AppBundle:Venta', 'v')
            ->join('v.clien', 'c')
            ->where('c = :cliente')
            ->setParameter('cliente', $usuario)
            ->getQuery()
            ->getResult();

        return $consulta;
    }

    public function getLineasSocioTemporada(Socio $socio, Temporada $temporada)
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('l')
            ->addSelect('v')
            ->addSelect('t')
            ->addSelect('s')
            ->from('AppBundle:Linea', 'l')
            ->join('l.venta', 'v')
            ->join('v.temporada', 't')
            ->join('v.socio', 's')
            ->where('t = :temporada')
            ->andWhere('s = :socio')
            ->setParameter('temporada', $temporada)
            ->setParameter('socio', $socio)
            ->getQuery()
            ->getResult();

        return $consulta;
    }
}
