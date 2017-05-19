<?php

namespace AppBundle\Service;

use AppBundle\Entity\Socio;
use AppBundle\Entity\Temporada;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CalculoLiquidacion extends Controller
{
    protected $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function calculoLiquidacionAction(Socio $socio, Temporada $temporada = null)
    {
        $em = $this->entityManager;

        //Si no recibe ninguna temporada se obtendrá la actual
        if (null === $temporada) {
            //Creamos una instancia del servicio
            $temporadaActual = new TemporadaActual($em);
            $temporada = $temporadaActual->temporadaActualAction();
        }

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
            ->getVentasTemporadaSocio($temporada, $socio);

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
            $sumaVenta = $venta->getSuma();
            $descuento = $sumaVenta * $venta->getDescuento();
            $baseImponible = $sumaVenta - $descuento;
            $sumaIva = $baseImponible * $venta->getIva();
            $totalVenta = $baseImponible + $sumaIva;
            $sumaVentasTemporada = $sumaVentasTemporada + $totalVenta;
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

        if ($contadorRendimientos != 0) {
            $rendimientoMedio = $sumaRendimientos / $contadorRendimientos;
        }
        else {
            $rendimientoMedio = 0;
        }

        //Suma de las cantidades de cada venta
        $sumaVentas = 0;
        for ($i = 0; $i < sizeof($ventas); $i++) {
            $cantidad = $ventas[$i]->getSuma() - ($ventas[$i]->getSuma() * $ventas[$i]->getDescuento());
            $sumaVentas = $sumaVentas + $cantidad;
        }

        if ($sumaEntregas != 0) {
            $precioLiquidacion = (($sumaMovimientos + $sumaVentasTemporada) / $sumaEntregas);
        }
        else {
            $precioLiquidacion = 0;
        }

        return [
            $liquidacion,
            $sumaEntregas,
            $sumaVentas,
            $pesoAceituna,
            $pesoAceite,
            $rendimientoMedio,
            $porcentajes,
            $sumaBonificacion,
            $precioLiquidacion,
        ];
    }
}