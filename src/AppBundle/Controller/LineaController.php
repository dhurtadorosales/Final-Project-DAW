<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Linea;
use AppBundle\Entity\Socio;
use AppBundle\Entity\Venta;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Tests\Compiler\Lille;
use Symfony\Component\HttpFoundation\Request;

class LineaController extends Controller
{
    /**
     * @Route("/ventas/detalle/{venta}", name="ventas_detalle")
     */
    public function detalleAction(Venta $venta)
    {
        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        $lineas = $em->createQueryBuilder()
            ->select('l')
            ->from('AppBundle:Linea', 'l')
            ->where('l.venta = :venta')
            ->setParameter('venta', $venta)
            ->getQuery()
            ->getResult();

        return $this->render('venta/detalle.html.twig', [
            'lineas' => $lineas,
            'venta' => $venta
        ]);
    }

    /**
     * @Route("/lineas/insertar", name="lineas_insertar")
     */
    public function insertarAction()
    {
        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        $venta = $em->createQueryBuilder()
            ->select('v')
            ->from('AppBundle:Venta', 'v')
            ->where('v.id = 1')
            ->getQuery()
            ->getResult();

        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        $lote = $em->createQueryBuilder()
            ->select('l')
            ->from('AppBundle:Lote', 'l')
            ->where('l.id = 1')
            ->getQuery()
            ->getResult();


        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

            $linea = new Linea();
            $em->persist($linea);
            $linea
                ->setCantidad(10)
                ->setVenta($venta)
                ->setLote($lote);

            $em->flush();

        $mensaje = 'Clientes insertados correctamente';

        return $this->render('cliente/operaciones.html.twig', [
            'mensaje' => $mensaje
        ]);
    }
}
