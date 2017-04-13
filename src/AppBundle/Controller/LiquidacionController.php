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

        //Suma datos para liquidacion
        $pesoAceituna = 0;
        $pesoAceite = 0;
        $sumaRendimientos = 0;
        $contadorRendimientos = 0;
        $sumaEntregas = 0;
        foreach ($entregas as $entrega) {
            if ($socio == $entrega->getFinca()->getPropietario()) {
                $peso = $entrega->getPeso() * $entrega->getFinca()->getPartPropietario();
            }
            else {
                $peso = $entrega->getPeso() * $entrega->getFinca()->getPartArrend();
            }
            $pesoAceituna = $pesoAceituna + $peso;

            $cantidad = ($peso * $entrega->getRendimiento())
                - ($peso * $entrega->getRendimiento() * $entrega->getSancion())
                + ($peso * $entrega->getRendimiento() * $entrega->getProcedencia()->getBonificacion());
            $pesoAceite = $pesoAceite + $cantidad;

            $sumaRendimientos = $sumaRendimientos + $entrega->getRendimiento();
            $contadorRendimientos ++;

            $precio = $entrega->getPrecioKgAceite();
            $sumaEntregas = $sumaEntregas + ($cantidad * $precio);
        }

        $rendimientoMedio = $sumaRendimientos / $contadorRendimientos;

        //Suma de las cantidades de cada venta
        $sumaVentas = 0;
        for ($i = 0; $i < sizeof($ventas); $i++) {
            $cantidad = $ventas[$i]->getBaseImponible();
            $sumaVentas = $sumaVentas + $cantidad;
        }

        return $this->render('liquidacion/detalle.html.twig', [
            'liquidacion' => $liquidacion,
            'socio' => $socio,
            'temporada' => $temporada,
            'sumaEntregas' => $sumaEntregas,
            'sumaVentas' => $sumaVentas,
            'pesoAceituna' => $pesoAceituna,
            'pesoAceite' => $pesoAceite,
            'rendimientoMedio' => $rendimientoMedio,
            'porcentajes' => $porcentajes
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