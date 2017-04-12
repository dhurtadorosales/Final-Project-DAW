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

class ConsultasRepository extends EntityRepository
{
    public function getProcedencias()
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('p')
            ->from('AppBundle:Procedencia', 'p')
            ->getQuery()
            ->getResult();

        return $consulta;
    }

    public function getSocios()
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('s')
            ->from('AppBundle:Socio', 's')
            ->getQuery()
            ->getResult();

        return $consulta;
    }

    public function getFincas()
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('f')
            ->from('AppBundle:Finca', 'f')
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

    public function getPartidas()
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('p')
            ->from('AppBundle:Partida', 'p')
            ->getQuery()
            ->getResult();

        return $consulta;
    }


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

    public function getEntregas()
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('e')
            ->from('AppBundle:Entrega', 'e')
            ->getQuery()
            ->getResult();

        return $consulta;
    }

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

    public function getEntregasPartida(Partida $partida)
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('e')
            ->addSelect('p')
            ->from('AppBundle:Entrega', 'e')
            ->join('e.partida', 'p')
            ->where('p = :partida')
            ->setParameter('partida', $partida)
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
            ->addSelect('p')
            ->addSelect('l')
            ->from('AppBundle:Entrega', 'e')
            ->join('e.partida', 'p')
            ->join('p.lote', 'l')
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
            ->join('f.arrendatario', 'a')
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
            ->join('f.arrendatario', 'a')
            ->where('e.id = :ent')
            ->andwhere('p = :socio')
            ->orwhere('a = :socio')
            ->setParameter('ent', $entrega)
            ->setParameter('socio', $socio)
            ->getQuery()
            ->getResult();

        return $consulta;
    }

    public function getLotes()
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('l')
            ->from('AppBundle:Lote', 'l')
            ->getQuery()
            ->getResult();

        return $consulta;
    }

    public function getLotesTemporada(Temporada $temporada)
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('l')
            ->addSelect('t')
            ->from('AppBundle:Lote', 'l')
            ->join('l.temporada', 't')
            ->where('t = :temporada')
            ->setParameter('temporada', $temporada)
            ->getQuery()
            ->getResult();

        return $consulta;
    }

    public function getLoteUnico(Lote $lote)
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('l')
            ->from('AppBundle:Lote', 'l')
            ->where('l.id = :lot')
            ->setParameter('lot', $lote)
            ->getQuery()
            ->getResult();

        return $consulta;
    }


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

    public function getVentasDetalle(Venta $venta)
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

    public function getVentasSocioTemporada(Socio $socio, Temporada $temporada)
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('v')
            ->addSelect('t')
            ->addSelect('s')
            ->from('AppBundle:Venta', 'v')
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

    public function getVentasCliente(Cliente $cliente)
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $consulta = $em->createQueryBuilder()
            ->select('v')
            ->addSelect('c')
            ->from('AppBundle:Venta', 'v')
            ->join('v.cliente', 'c')
            ->where('c = :cliente')
            ->setParameter('cliente', $cliente)
            ->getQuery()
            ->getResult();

        return $consulta;
    }

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
