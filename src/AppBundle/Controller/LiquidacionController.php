<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Linea;
use AppBundle\Entity\Liquidacion;
use AppBundle\Entity\Lote;
use AppBundle\Entity\Porcentaje;
use AppBundle\Entity\Producto;
use AppBundle\Entity\Socio;
use AppBundle\Entity\Temporada;
use AppBundle\Entity\Venta;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Tests\Compiler\Lille;
use Symfony\Component\HttpFoundation\Request;

class LiquidacionController extends Controller
{
    /**
     * @Route("/liquidaciones/listar/{temporada}", name="liquidaciones_listar_temporada")
     */
    public function listarAction(Temporada $temporada)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $liquidaciones = $em->getRepository('AppBundle:Liquidacion')
            ->getLiquidacionTemporada($temporada);

        return $this->render('liquidacion/listar.html.twig', [
            'liquidaciones' => $liquidaciones,
            'temporada' => $temporada
        ]);
    }

    /**
     * @Route("/liquidaciones/detalle/{socio}/{temporada}", name="liquidaciones_detalle")
     */
    public function detalleAction(Socio $socio, Temporada $temporada)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Obtención de los socios
        $socios = $em->getRepository('AppBundle:Socio')
            ->findAll();

        //Obtención de los porcentajes
        $porcentajes = $em->getRepository('AppBundle:Porcentaje')
            ->findAll();

        //Obtención de la liquidación correspondiente
        $liquidacion = $em->getRepository('AppBundle:Liquidacion')
                ->getLiquidacionDetalle($socio, $temporada);

        //Obtencion de las entregas del socio en esa temporada
        $entregas = $em->getRepository('AppBundle:Entrega')
                ->getEntregasSocioTemporada($socio, $temporada);

        //Obtención de las compras hechas por el socio en esa temporada
        $ventas = $em->getRepository('AppBundle:Venta')
                ->getVentasSocioTemporada($socio, $temporada);

        //Obtención movimientos de la temporada
        $movimientos = $em->getRepository('AppBundle:Movimiento')
            ->getMovimientosTemporada($temporada);

        //Obtención ventas de la temporada
        $ventasTemporada = $em->getRepository('AppBundle:Venta')
            ->getVentasTemporada($temporada);

        //Obtencion de todas las entregas en esa temporada
        $entregasTemporada = $em->getRepository('AppBundle:Entrega')
            ->getEntregasTemporada($temporada);

        //Cálculo de suma de movimientos
        $sumaMovimientos = 0;
        foreach ($movimientos as $movimiento) {
            $sumaMovimientos = $sumaMovimientos + $movimiento->getCantidad();
        }

        //Cálculo de suma de ventas de la temporada
        $sumaVentasTemporada = 0;
        foreach ($ventasTemporada as $venta) {
            $sumaVentasTemporada = $sumaVentasTemporada + ($venta->getSuma() - ($venta->getSuma() * $venta->getDescuento()) + ($venta->getSuma() - ($venta->getSuma() * $venta->getDescuento()) * $venta->getIva()));
        }

        //Cálculo de suma de kg entregas
        $sumaEntregas = 0;
        foreach ($entregasTemporada as $entrega) {
            $sumaEntregas = $sumaEntregas + ($entrega->getPeso() * $entrega->getRendimiento());
        }

        //Suma datos para liquidacion
        $pesoAceituna = 0;
        $pesoAceite = 0;
        $sumaRendimientos = 0;
        $sumaBonificacion = 0;
        $contadorRendimientos = 0;
        foreach ($entregas as $entrega) {
            if ($socio == $entrega->getFinca()->getPropietario()) {
                $peso = ($entrega->getPeso() * $entrega->getFinca()->getPartPropietario()) - ($entrega->getPeso() * $entrega->getFinca()->getPartPropietario() * $entrega->getSancion());
            }
            else {
                $peso = ($entrega->getPeso() * $entrega->getFinca()->getPartArrend()) - ($entrega->getPeso() * $entrega->getFinca()->getPartArrend() *$entrega->getSancion());
            }
            $pesoAceituna = $pesoAceituna + $peso;

            $cantidad = ($peso * $entrega->getRendimiento());
            $pesoAceite = $pesoAceite + $cantidad;

            $sumaBonificacion = $sumaBonificacion + ($entrega->getProcedencia()->getBonificacion() * $peso);

            $sumaRendimientos = $sumaRendimientos + $entrega->getRendimiento();
            $contadorRendimientos ++;

        }

        $rendimientoMedio = $sumaRendimientos / $contadorRendimientos;

        //Suma de las cantidades de cada venta
        $sumaVentas = 0;
        for ($i = 0; $i < sizeof($ventas); $i++) {
            $cantidad = $ventas[$i]->getSuma() - ($ventas[$i]->getSuma() * $ventas[$i]->getDescuento());
            $sumaVentas = $sumaVentas + $cantidad;
        }

        $precioLiquidacion = (($sumaMovimientos + $sumaVentasTemporada) / $sumaEntregas) / (sizeof($socios) - 1);

        return $this->render('liquidacion/detalle.html.twig', [
            'liquidacion' => $liquidacion,
            'socio' => $socio,
            'temporada' => $temporada,
            'sumaEntregas' => $sumaEntregas,
            'sumaVentas' => $sumaVentas,
            'pesoAceituna' => $pesoAceituna,
            'pesoAceite' => $pesoAceite,
            'rendimientoMedio' => $rendimientoMedio,
            'porcentajes' => $porcentajes,
            'sumaBonificacion' => $sumaBonificacion,
            'precioLiquidacion' => $precioLiquidacion
        ]);
    }

    /**
     * @Route("/liquidaciones/insertar", name="liquidaciones_insertar")
     */
    public function insertarLiquidacionAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Obtenemos la última temporada
        $temporadas = $resultados = $em->getRepository('AppBundle:Temporada')
            ->findAll();
        $temporada = $temporadas[sizeof($temporadas) - 1];

        //Obtención de todos los socios
        $socios = $em->getRepository('AppBundle:Socio')
            ->findAll();

        //Obtención de los porcentajes vigentes
        $porcentajes = $em->getRepository('AppBundle:Porcentaje')
            ->findAll();

        //Creación de la liquidación de cada socio
        foreach ($socios as $item) {
            $liquidacion = new  Liquidacion();
            $em->persist($liquidacion);
            $liquidacion
                ->setTemporada($temporada)
                ->setBeneficio(0)
                ->setGasto(0)
                ->setIva($porcentajes[0]->getCantidad())
                ->setIvaReducido($porcentajes[1]->getCantidad())
                ->setRetencion($porcentajes[2]->getCantidad())
                ->setIndiceCorrector($porcentajes[3]->getCantidad())
                ->setSocio($item);
        }
        $em->flush();

        $mensaje = 'Liquidacion insertada correctamente';

        return $this->render('liquidacion/confirma.html.twig', [
            'mensaje' => $mensaje
        ]);
    }
}
